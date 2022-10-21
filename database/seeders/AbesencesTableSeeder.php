<?php

namespace Database\Seeders;

use App\Models\Procedures\Absences;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AbesencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Absences::create(
            [
                'student_id'=>2,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>1               
            ]
        );
        Absences::create(
            [
                'student_id'=>2,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"2 تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>2                
            ]
        );
        Absences::create(
            [
                'student_id'=>2,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"3 تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>3             
            ]
        );
        Absences::create(
            [
                'student_id'=>5,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"2 تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>3             
            ]
        );
        Absences::create(
            [
                'student_id'=>6,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"6 تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>3             
            ]
        );
        Absences::create(
            [
                'student_id'=>6,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"6 تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>2             
            ]
        );
        Absences::create(
            [
                'student_id'=>7,
                'absence_date'=>Carbon::parse('12/02/2022'),
                'absence_reason'=>"6 تجربة",
                'teacher_signature'=>"توقيع",
                'absence_type_id'=>2            
            ]
        );
    }
}
