<?php

namespace Database\Seeders;

use App\Models\Auth\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolePermission::create(
            [
                'role_id'=>1,
             'permission_id'=>1
            ]);
            RolePermission::create(
                [
                    'role_id'=>1,
                 'permission_id'=>2
                ]);
                RolePermission::create(
                    [
                        'role_id'=>2,
                     'permission_id'=>3
                    ]);
                    RolePermission::create(
                        [
                            'role_id'=>2,
                         'permission_id'=>4
                        ]); 
                        RolePermission::create(
                            [
                                'role_id'=>2,
                             'permission_id'=>5
                            ]); 
                            RolePermission::create(
                                [
                                    'role_id'=>2,
                                 'permission_id'=>6
                                ]); 
                                RolePermission::create(
                                    [
                                        'role_id'=>2,
                                     'permission_id'=>7
                                    ]);  
                                    RolePermission::create(
                                        [
                                            'role_id'=>3,
                                         'permission_id'=>4
                                        ]);  
    }
}
