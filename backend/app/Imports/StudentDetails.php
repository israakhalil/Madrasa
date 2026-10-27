<?php

namespace App\Imports;

use App\Models\School\Students;
use Carbon\Carbon;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentDetails extends DefaultValueBinder implements ToModel, WithStartRow, WithCustomValueBinder
{
    protected $class_id;
    // protected $name;
    private $date_format = 'Y-m-d';
    private $date_columns = ['E'];

    // bind date formats to column defined above
    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), $this->date_columns)) {
            $cell->setValueExplicit(Date::excelToDateTimeObject($value)->format($this->date_format), DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
    public function startRow(): int
    {
        return 2;
    }
      
    public function __construct(int $class_id, string $name)
    {
        $this->class_id = $class_id;
        // $this->name = $name;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
            // $student->phone_1= $data->phone_1;
            // $student->phone_2= $data->phone_2;
            // $student->phone_3= $data->phone_3;
            // $student->date_of_birth=Carbon::parse($data->date_of_birth);
            // $student->attached_id=$filename;

        return new Students([
          'name' =>$row[0],
          'class_id' =>$this->class_id,
          'id_number'=>$row[1],
          "phone_1"=>$row[2],
          "phone_2"=>$row[3],
          'date_of_birth' =>$row[4],
        //   "date_of_birth"=>Carbon::createFromFormat('m/d/Y', $row[4])->format('Y-m-d')
          //date('Y-m-d h:i:s', strtotime($row[4]))
          //Carbon::createFromFormat('Y-m-d', $row[4])->format('m/d/Y')
         //   $date = Carbon::createFromFormat('m/d/Y', $myDate)->format('Y-m-d');
        //  $input = '06/10/2011 19:00:02';
        //  $date = strtotime($input);
        //  echo date('d/M/Y h:i:s', $date);
  
         // date('m/d/Y',$row[4]),
          //Carbon::parse($row[4])->format('m-d-Y'),
          // Carbon::parse($row[4])->format(m/d/Y')
        
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
