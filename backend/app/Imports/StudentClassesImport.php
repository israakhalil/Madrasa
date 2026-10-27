<?php

namespace App\Imports;

use App\Models\School\Students;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentClassesImport implements ToModel, WithStartRow
{
    protected $class_id;
      
    public function __construct(int $class_id)
    {
        $this->class_id = $class_id;
    }

    public function startRow(): int
    {
        return 2;
    }
      
    public function model(array $row)
    {
        return new Students([
          'name' =>$row[0],
          'class_id' =>$this->class_id,
        
        ]);



        // return new User([
        //     'username' =>$row['username'],
        //     'id_number'=> $row['id_number'],
        //     'name'     => $row['name'],
        //     'email'    => $row['email'],
        //     'password' => Hash::make($row['password']),
        //     'department_id'=> $row['dept_id'],
        // ]);
    }
}
