<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            MasterDataSeeder::class,
            PeopleSeeder::class,
            AcademicSeeder::class,
            AttendanceGradeSeeder::class,
            LmsSeeder::class,
            CbtSeeder::class,
        ]);
    }
}
