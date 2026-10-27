<?php

namespace App\Models\Core;

use App\Exceptions\DBSPException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
use Yajra\Pdo\Oci8\Statement;

class BaseModel extends Model
{

    protected $sp_package_name;
    protected $sp_create_name;
    protected $sp_get_name;
    protected $sp_show_name;
    protected $sp_update_name;
    protected $sp_delete_name;
    protected $pdo;
    protected $query_str = "";
    protected $output_code;


    public function __construct(array $attributes = [])
    {
        $this->pdo = DB::getPdo();
        parent::__construct($attributes);
    }

    public function createSqlFromProcedure($procedureName, array $bindings, $cursor = false)
    {
        $paramsString = implode(',', array_map(function ($param) {
            return ':' . $param;
        }, array_keys($bindings)));

        $prefix = count($bindings) ? ',' : '';
        if (is_array($cursor)) {
            $cursor = $cursor['name'] ? $prefix . $cursor['name'] : null;
        } else if ($cursor) {
            $cursor = $cursor ? $prefix . $cursor : null;
        }

        return sprintf('begin %s(%s%s); end;', $procedureName, $paramsString, $cursor);
    }

    public function createStatementFromProcedure($procedureName, array $bindings, $cursorName = false)
    {
        $sql = $this->createSqlFromProcedure($procedureName, $bindings, $cursorName);
        return $this->pdo->prepare($sql);
    }


    public function addBindingsToStatement(\PDOStatement $stmt, array $bindings)
    {
        foreach ($bindings as $key => &$binding) {

            $value = &$binding;
            $type = \PDO::PARAM_STR;
            $length = -1;

            if ($key == 'query') {
                $stmt->bindParam(':query', $this->query_str, PDO::PARAM_STR, $length);
            } else {
                if (is_array($binding)) {
                    $value = &$binding['value'];
                    $type = array_key_exists('type', $binding) ? $binding['type'] : PDO::PARAM_STR;
                    $length = array_key_exists('length', $binding) ? $binding['length'] : -1;
                }
                $stmt->bindParam(':' . $key, $value, $type, $length);
            }

        }

        return $stmt;
    }

    public function executeProcedure($procedureName, array $bindings = [])
    {
        $stmt = $this->createStatementFromProcedure($procedureName, $bindings);
        $stmt = $this->addBindingsToStatement($stmt, $bindings);
        return $stmt->execute();
    }


    public function executeProcedureWithCursor($procedureName, array $bindings = [], $cursorName = ':cursor')
    {
        $stmt = $this->createStatementFromProcedure($procedureName, $bindings, $cursorName);
        $stmt = $this->addBindingsToStatement($stmt, $bindings);

        $cursor = null;

        if (is_array($cursorName)) {
            $stmt->bindParam($cursorName['name'], $cursor, $cursorName['type']);
        } else {
            $stmt->bindParam($cursorName, $cursor, PDO::PARAM_STMT);
        }
        $stmt->execute();
        $statement = new Statement($cursor, $this->pdo, $this->pdo->getOptions());
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $results;
    }


    public function getAll(array $parameters, $cursor, $has_paginator_parameter = true)
    {

        if ($has_paginator_parameter) {
            $parameters['pagenumber'] = ['value' => 0, 'type' => PDO::PARAM_INT];
            $parameters['pagesize'] = ['value' => 0, 'type' => PDO::PARAM_INT];
            $parameters['Total_Records'] = ['value' => &$total_records, 'type' => PDO::PARAM_INT];
        }

        $result = $this->executeProcedureWithCursor(($this->sp_package_name . '.' . $this->sp_get_name), $parameters, $cursor);

        return collect($this->newModelQuery()->hydrate(
            $result
        )->all());
    }

    public function paginateData(array $parameters, $cursor, $page_size = 10)
    {
        if (request()->filled('page') && request('page', 1) > 1) {
            $page = request('page');
        } else {
            $page = 1;
        }

        if (request()->filled('page_size') && request('page_size', 1) > 1) {
            $page_size = request('page_size');
        }


        $parameters['pagenumber'] = ['value' => $page, 'type' => PDO::PARAM_INT];
        $parameters['pagesize'] = ['value' => $page_size, 'type' => PDO::PARAM_INT];
        $parameters['Total_Records'] = ['value' => &$total_records, 'type' => PDO::PARAM_INT];

        $result = $this->executeProcedureWithCursor(($this->sp_package_name . '.' . $this->sp_get_name), $parameters, $cursor);
        $items = $this->newModelQuery()->hydrate(
            $result
        );
        return collect([
            'items' => $items,
            'per_page' => $page_size,
            'page_number' => $page,
            'has_next_page' => true,
            'total_records' => $total_records,
            'total_pages' => ceil($total_records / $page_size),
        ])->all();

    }

    public function find(array $parameters, $cursor)
    {
        $result = $this->executeProcedureWithCursor(($this->sp_package_name . '.' . $this->sp_show_name), $parameters, $cursor);
        return count($result) ? collect($this->newModelQuery()->hydrate(
            $result
        )->all())->first() : collect([])->first();
    }

    public function createItem(array $parameters, $cursor)
    {
        $parameters['O_RES_CODE'] = ['value' => &$this->output_code, 'type' => PDO::PARAM_STR, 'length' => 500];

        $result = $this->executeProcedureWithCursor(($this->sp_package_name . '.' . $this->sp_create_name), $parameters, $cursor);

        if ($this->output_code == 200) {
            return isset($result) ? collect($this->newModelQuery()->hydrate(
                $result
            )->all())->first() : null;
        } else {
            throw new DBSPException('', 0, null, $this->output_code);
        }
    }

    public function updateItem(array $parameters, $cursor = null)
    {
        $parameters['O_RES_CODE'] = ['value' => &$this->output_code, 'type' => PDO::PARAM_STR, 'length' => 500];
        if (isset($cursor)) {
            $result = $this->executeProcedureWithCursor(($this->sp_package_name . '.' . $this->sp_update_name), $parameters, $cursor);
            if ($this->output_code == 200) {
                return isset($result) ? collect($this->newModelQuery()->hydrate(
                    $result
                )->all())->first() : null;
            } else {
                throw new DBSPException('', 0, null, $this->output_code);
            }
        } else {
            $result =  $this->executeProcedure(($this->sp_package_name . '.' . $this->sp_update_name), $parameters);
            if ($this->output_code == 200) {
                return $this->output_code == 200;
            } else {
                throw new DBSPException('', 0, null, $this->output_code);
            }
        }

    }

    public function deleteItems(array $parameters)
    {
        return $this->executeProcedure(($this->sp_package_name . '.' . $this->sp_delete_name), $parameters);
    }


}
