<?php

namespace Database\Seeders;

use App\Models\Auth\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRoles::create(
            [
                'user_id' => 1,
                'role_id' => 1                
            ]
        );
    }
}
