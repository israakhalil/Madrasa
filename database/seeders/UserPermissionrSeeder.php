<?php

namespace Database\Seeders;

use App\Models\Auth\UserPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermissionrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPermission::create(
            [
                'user_id'=>1,
             'permission_id'=>1
            ]);
        UserPermission::create(
            [
                'user_id'=>1,
                'permission_id'=>2
            ]);
    }
}
