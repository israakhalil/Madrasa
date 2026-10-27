<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            roleSeeder::class,
            PermissionsSeeder::class,
            RolePermissionsSeeder::class,

            SchoolSeeder::class,
            LevelSeeder::class,
            classSeeder::class,

            AdminUserSeeder::class,
            UserPermissionrSeeder::class,

            AbesenceTypeTableSeeder::class,
            ViolationDegreeSeeder::class,
            violationProceduresSeeder::class,

            StudentsTableSeeder::class,
            AbesencesTableSeeder::class,
        ]);
    }
}
