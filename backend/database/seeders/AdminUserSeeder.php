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
            'name'=>"احمد محمود",
            'email'=>"admin@gmail.com",
            'password'=>Hash::make("123456"),
            'school_id'=>0,
            'role_id'=>1,
        ]

       );

    }
}
