<?php

namespace Database\Seeders;

use App\Models\Constants\ViolationDegrees;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViolationDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ViolationDegrees::create(
            [
                'name' => "فصل",                
            ]
        );
        ViolationDegrees::create(
            [
                'name' => "طرد",                
            ]
        );
    }
}
