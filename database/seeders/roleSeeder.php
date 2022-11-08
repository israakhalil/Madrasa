<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(
            [
                'name' => "مدير النظام",                
            ]
        );
        Role::create(
            [
                'name' => "مشرف",                
            ]
        );
        Role::create(
            [
                'name' => "اداري",                
            ]
        );
    }
}
