<?php

namespace App\Imports;

use App\Models\School\Students;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentClassesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Students([
          'name' =>$row[0],
          'class_id' =>$row[1],
        
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
