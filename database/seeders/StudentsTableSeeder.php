<?php

namespace Database\Seeders;

use App\Models\School\Students;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ar_SA');
        $classIds = range(1, 7);
        $nationalities = ['فلسطيني', 'أردني', 'مصري', 'سوري', 'لبناني'];

        foreach ($classIds as $classId) {
            $studentsPerClass = $faker->numberBetween(15, 25);

            for ($i = 0; $i < $studentsPerClass; $i++) {
                Students::create([
                    'name'          => $faker->name(),
                    'id_number'     => $faker->unique()->numerify('#########'),
                    'class_id'      => $classId,
                    'date_of_birth' => Carbon::now()
                        ->subYears($faker->numberBetween(15, 19))
                        ->subDays($faker->numberBetween(0, 365))
                        ->toDateString(),
                    'phone_1'       => '059' . $faker->numerify('#######'),
                    'phone_2'       => '059' . $faker->numerify('#######'),
                    'phone_3'       => '',
                    'nationality'   => $faker->randomElement($nationalities),
                    'attached_id'   => '',
                ]);
            }
        }
    }
}
