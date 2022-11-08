<?php

namespace Database\Seeders;

use App\Models\School\Students;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Students::create([
            'name'=>"israa",
            'id_number'=>"256256256",
        'class_id'=>8,
        'date_of_birth'=>Carbon::parse('12/02/2022'),
        'phone_1'=>'0598769955',
        'phone_2'=>'059876995',
        'phone_3'=>'',
        'attached_id'=>''
        ]
       );
       Students::create([
        'name'=>"walaa",
        'id_number'=>"256256256",
    'class_id'=>8,
    'date_of_date'=>Carbon::parse('12/02/2022'),
    'phone_1'=>'0598769955',
    'phone_2'=>'059876995',
    'phone_3'=>'',
    'attached_id'=>''
    ]
   );
   Students::create([
    'name'=>"doaa",
    'id_number'=>"256256256",
'class_id'=>9,
'date_of_birth'=>Carbon::parse('12/02/2022'),
'phone_1'=>'0598769955',
'phone_2'=>'059876995',
'phone_3'=>'',
'attached_id'=>''
]
);
Students::create([
    'name'=>"doaa",
    'id_number'=>"256256256",
'class_id'=>13,
'date_of_date'=>Carbon::parse('12/02/2022'),
'phone_1'=>'0598769955',
'phone_2'=>'059876995',
'phone_3'=>'',
'attached_id'=>''
]
);
Students::create([
    'name'=>"doaa",
    'id_number'=>"256256256",
'class_id'=>13,
'date_of_date'=>Carbon::parse('12/02/2022'),
'phone_1'=>'0598769955',
'phone_2'=>'059876995',
'phone_3'=>'',
'attached_id'=>''
]
);
       
    }
}
