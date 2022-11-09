<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\school\Classes;

class classSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classes::create(
            [
                'name' => "الصف الاول",
                'level_id' => 1,
                'attached_file' => "",
                'school_id' => 1,
                'user_id' => 1,
            ]
        );
        Classes::create(
            [
                'name' => "الصف الثاني",
                'level_id' => 1,
                'attached_file' => "",
                'school_id' => 1,
                'user_id' => 1,
            ]
        );
        Classes::create(
            [
                'name' => "الصف الثالث",
                'level_id' => 1,
                'attached_file' => "",
                'school_id' => 1,
                'user_id' => 1,
            ]
        );
        Classes::create(
            [
                'name' => "الصف الاول",
                'level_id' => 3,
                'attached_file' => "",
                'school_id' => 1,
                'user_id' => 1,
            ]
        );
        Classes::create(
            [
                'name' => "الصف الثاني",
                'level_id' => 3,
                'attached_file' => "",
                'school_id' => 1,
                'user_id' => 1,
            ]
        );
        Classes::create(
            [
                'name' => "الصف الاول",
                'level_id' => 4,
                'attached_file' => "",
                'school_id' => 2,
                'user_id' => 2,
            ]
        );
        Classes::create(
            [
                'name' => "الصف الثاني",
                'level_id' => 5,
                'attached_file' => "",
                'school_id' => 2,
                'user_id' => 2,
            ]
        );
    }
}
