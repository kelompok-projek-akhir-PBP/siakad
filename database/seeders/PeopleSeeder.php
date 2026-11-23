<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PeopleSeeder extends DummySeeder
{
    public const TEACHER_COUNT = 15;
    public const STUDENT_COUNT = 50;

    public const CLASS_LAYOUT = [
        ['RPL', 1],
        ['RPL', 2],
        ['TKJ', 1],
        ['TKJ', 2],
        ['DKV', 1],
    ];

    public function run(): void
    {
        $now = now();
        $faker = fake('id_ID');
        $hash = Hash::make('Password@123');
        $majors = DB::table('majors')->pluck('id', 'abbreviation')->all();

        // GURU
        $userRows = [];
        for ($i = 1; $i <= self::TEACHER_COUNT; $i++) {
            $userRows[] = [
                'username' => sprintf('19800101201001%04d', $i),
                'password' => $hash,
                'role' => 'teacher',
                'must_change_password' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('users')->insert($userRows);
        $userIds = DB::table('users')->where('role', 'teacher')->pluck('id', 'username')->all();

        $rows = [];
        foreach ($userRows as $i => $user) {
            $gender = $i % 2 === 0 ? 'L' : 'P';
            $rows[] = [
                'user_id' => $userIds[$user['username']],
                'nip' => $user['username'],
                'name' => $faker->name($gender === 'L' ? 'male' : 'female'),
                'gender' => $gender,
                'birth_place' => $faker->city(),
                'birth_date' => $faker->dateTimeBetween('1970-01-01', '1998-12-31')->format('Y-m-d'),
                'phone' => '08'.$faker->numerify('##########'),
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('teachers')->insert($rows);

        // SISWA
        $layoutCount = count(self::CLASS_LAYOUT);
        $userRows = [];
        for ($i = 1; $i <= self::STUDENT_COUNT; $i++) {
            $userRows[] = [
                'username' => sprintf('2026%04d', $i),
                'password' => $hash,
                'role' => 'student',
                'must_change_password' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->insertChunked('users', $userRows);
        $userIds = DB::table('users')->where('role', 'student')->pluck('id', 'username')->all();

        $rows = [];
        foreach ($userRows as $i => $user) {
            $gender = $i % 2 === 0 ? 'L' : 'P';
            $majorAbbr = self::CLASS_LAYOUT[$i % $layoutCount][0];
            $rows[] = [
                'user_id' => $userIds[$user['username']],
                'nis' => $user['username'],
                'name' => $faker->name($gender === 'L' ? 'male' : 'female'),
                'gender' => $gender,
                'birth_place' => $faker->city(),
                'birth_date' => $faker->dateTimeBetween('2010-01-01', '2011-12-31')->format('Y-m-d'),
                'phone' => '08'.$faker->numerify('##########'),
                'major_id' => $majors[$majorAbbr],
                'entry_year' => 2026,
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->insertChunked('students', $rows);
    }
}
