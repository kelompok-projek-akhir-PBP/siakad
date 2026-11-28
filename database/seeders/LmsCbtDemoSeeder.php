<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassEnrollment;
use App\Models\Classroom;
use App\Models\Major;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class LmsCbtDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (['admin', 'teacher', 'student'] as $roleName) {
                Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            }

            $year = AcademicYear::firstOrCreate(
                ['name' => '2026/2027'],
                ['start_date' => '2026-07-13', 'end_date' => '2027-06-26', 'is_active' => true]
            );
            $ganjil = Semester::firstOrCreate(
                ['academic_year_id' => $year->id, 'type' => 'ganjil'],
                ['start_date' => '2026-07-13', 'end_date' => '2026-12-19', 'is_active' => true]
            );
            Semester::firstOrCreate(
                ['academic_year_id' => $year->id, 'type' => 'genap'],
                ['start_date' => '2027-01-04', 'end_date' => '2027-06-26', 'is_active' => false]
            );

            $major = Major::firstOrCreate(
                ['name' => 'Rekayasa Perangkat Lunak'],
                ['abbrevation' => 'RPL', 'is_active' => true]
            );

            $subjects = collect(['Matematika', 'Bahasa Indonesia', 'Informatika'])
                ->map(fn ($name) => Subject::firstOrCreate(
                    ['name' => $name],
                    ['kkm' => 70, 'is_active' => true]
                ));

            $classroom = Classroom::firstOrCreate([
                'academic_year_id' => $year->id,
                'major_id' => $major->id,
                'grade_level' => 10,
                'class_number' => 1,
            ]);

            $admin = User::firstOrCreate(
                ['email' => 'admin@siakad.test'],
                ['name' => 'Admin Demo', 'password' => 'password']
            );
            if (! $admin->hasRole('admin')) {
                $admin->assignRole('admin');
            }

            $teachers = collect(range(1, 3))->map(function ($n) {
                $user = User::firstOrCreate(
                    ['email' => "guru{$n}@siakad.test"],
                    ['name' => "Guru Demo {$n}", 'password' => 'password']
                );
                if (! $user->hasRole('teacher')) {
                    $user->assignRole('teacher');
                }

                return Teacher::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => sprintf('19800101201001%04d', $n),
                        'name' => "Guru Demo {$n}",
                        'gender' => $n % 2 === 0 ? 'P' : 'L',
                        'birth_place' => 'Surabaya',
                        'birth_date' => '1985-01-01',
                        'phone' => sprintf('08110000%04d', $n),
                        'status' => 'aktif',
                    ]
                );
            });

            foreach (range(1, 10) as $n) {
                $user = User::firstOrCreate(
                    ['email' => "siswa{$n}@siakad.test"],
                    ['name' => "Siswa Demo {$n}", 'password' => 'password']
                );
                if (! $user->hasRole('student')) {
                    $user->assignRole('student');
                }

                $student = Student::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nis' => sprintf('2026%04d', $n),
                        'name' => "Siswa Demo {$n}",
                        'gender' => $n % 2 === 0 ? 'P' : 'L',
                        'birth_place' => 'Surabaya',
                        'birth_date' => '2010-06-15',
                        'phone' => sprintf('08120000%04d', $n),
                        'major_id' => $major->id,
                        'status' => 'aktif',
                    ]
                );

                ClassEnrollment::firstOrCreate(
                    ['student_id' => $student->id, 'academic_year_id' => $year->id],
                    ['classroom_id' => $classroom->id]
                );
            }

            foreach ($subjects as $i => $subject) {
                TeachingAssignment::firstOrCreate(
                    [
                        'semester_id' => $ganjil->id,
                        'classroom_id' => $classroom->id,
                        'subject_id' => $subject->id,
                    ],
                    [
                        'teacher_id' => $teachers[$i]->id,
                        'weekly_jp_target' => 2,
                    ]
                );
            }
        });
    }
}