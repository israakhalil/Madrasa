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
        $this->call(LevelsSeeder::class);
        $this->call(ClassSeeder::class);
    }
}
