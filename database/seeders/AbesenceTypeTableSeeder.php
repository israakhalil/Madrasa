<?php

namespace Database\Seeders;

use App\Models\Constants\AbsenceTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbesenceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AbsenceTypes::create(
            [
                'name' => "حالة صحية",                
            ]
        );
        AbsenceTypes::create(
            [
                'name' => "حالة طارئة",                
            ]
        );
        AbsenceTypes::create(
            [
                'name' => " وفاء من الدرحة الاولى",                
            ]
        );
    }
}
