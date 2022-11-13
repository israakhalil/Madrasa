<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Auth\Permission;
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

        $this->call(roleSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(AbesenceTypeTableSeeder::class);
        $this->call(ViolationDegreeSeeder::class);
        $this->call(violationProceduresSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolePermissionsSeeder::class);



    }
}
