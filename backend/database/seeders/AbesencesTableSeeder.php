<?php

namespace Database\Seeders;

use App\Models\Procedures\Absences;
use App\Models\School\Students;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AbesencesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ar_SA');
        $studentIds = Students::pluck('id')->toArray();

        if (empty($studentIds)) {
            return;
        }

        $reasons = ['مرض', 'ظرف عائلي', 'موعد طبي', 'سفر', 'بدون عذر'];

        foreach ($studentIds as $studentId) {
            $absenceCount = $faker->numberBetween(0, 4);

            for ($i = 0; $i < $absenceCount; $i++) {
                Absences::create([
                    'student_id'        => $studentId,
                    'absence_date'      => Carbon::now()
                        ->subDays($faker->numberBetween(1, 180))
                        ->toDateString(),
                    'absence_reason'    => $faker->randomElement($reasons),
                    'teacher_signature' => $faker->name(),
                    'absence_type_id'   => $faker->numberBetween(1, 3),
                ]);
            }
        }
    }
}
