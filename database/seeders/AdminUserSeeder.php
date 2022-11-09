<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'=>"admin",
            'name'=>"admin",
            'email'=>"admin@gmail.com",
            'id_number'=>2562415,
            'password'=>Hash::make("123456"),
            'school_id'=>1,
        ]

       );
        User::create(
            ['username'=>"user",
        'name'=>"user ",
        'email'=>"user@gmail.com",
        'id_number'=>2562415,
        'password'=>Hash::make("123456"),
        'school_id'=>2,
    ]);


    }
}
