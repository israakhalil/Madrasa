<?php

namespace Database\Seeders;

use App\Models\Constants\ViolationDegrees;
use App\Models\Constants\ViolationProcedures;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class violationProceduresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ViolationProcedures::create(
            [
                'name' => "فصل",                
            ]
        );
        ViolationProcedures::create(
            [
                'name' => "طرد",                
            ]
        );
    }
}
