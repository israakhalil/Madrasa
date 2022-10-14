<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\school\Levels;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Levels::create( 
            ['name'=>"الثانوي الاول",
             'school_id'=>1
            ]);
        Levels::create( 
            ['name'=>"الثانوي الاول",
                'school_id'=>2
            ]);
        Levels::create( 
            ['name'=>"الثانوي الثاني",
                'school_id'=>1
            ]);
        Levels::create( 
            ['name'=>"الثانوي الثاني",
                'school_id'=>2
            ]);
        Levels::create( 
            ['name'=>"الثانوي الثالث",
                'school_id'=>1
            ]);
    }
}
