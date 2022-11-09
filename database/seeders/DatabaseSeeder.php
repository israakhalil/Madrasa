<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(SchoolSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(classSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(AbesenceTypeTableSeeder::class);
        $this->call(ViolationDegreeSeeder::class);
        $this->call(violationProceduresSeeder::class);



    }
}
