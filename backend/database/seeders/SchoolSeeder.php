<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\school\Schools;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schools::create([
            'name'=>"مدرسة الاسراء",
            'logo'=>"",
            'is_active'=>1,
        ]
       );
        Schools::create( [
            'name'=>"مدرسة الاستقلال",
            'logo'=>"",
            'is_active'=>1,
        ]);
    }
}
