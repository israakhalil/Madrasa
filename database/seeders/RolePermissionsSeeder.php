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
                                'role_id'=>2,
                                'permission_id'=>8
                            ]);   

                        RolePermission::create(
                            [
                                'role_id'=>2,
                                'permission_id'=>9
                            ]); 
                        RolePermission::create(
                            [
                                'role_id'=>2,
                                'permission_id'=>10
                            ]); 
                        // RolePermission::create(
                        //     [
                        //         'role_id'=>2,
                        //         'permission_id'=>11
                        //     ]); 
                        //     RolePermission::create(
                        //         [
                        //             'role_id'=>2,
                        //             'permission_id'=>12
                        //         ]); 
                        //     RolePermission::create(
                        //         [
                        //             'role_id'=>2,
                        //             'permission_id'=>13
                        //         ]);
                        //     RolePermission::create(
                        //         [
                        //             'role_id'=>2,
                        //             'permission_id'=>14
                        //         ]);
                        //     RolePermission::create(
                        //         [
                        //             'role_id'=>2,
                        //             'permission_id'=>15
                        //         ]);
                        //         RolePermission::create(
                        //             [
                        //                 'role_id'=>2,
                        //                 'permission_id'=>16
                        //             ]); 
                        //         RolePermission::create(
                        //             [
                        //                 'role_id'=>2,
                        //                 'permission_id'=>17
                        //             ]);
                        //         RolePermission::create(
                        //             [
                        //                 'role_id'=>2,
                        //                 'permission_id'=>18
                        //             ]);
                        //         RolePermission::create(
                        //             [
                        //                 'role_id'=>2,
                        //                 'permission_id'=>19
                        //             ]);
                        //             RolePermission::create(
                        //                 [
                        //                     'role_id'=>2,
                        //                     'permission_id'=>20
                        //                 ]);
                        //             RolePermission::create(
                        //                 [
                        //                     'role_id'=>2,
                        //                     'permission_id'=>21
                        //                 ]);
                      RolePermission::create(
                        [
                            'role_id'=>3,
                            'permission_id'=>4
                        ]);
                    
    }
}
