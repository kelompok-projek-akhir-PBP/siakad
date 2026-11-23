<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterDataSeeder extends DummySeeder
{
    public function run(): void
    {
        $now = now();

        // Akun admin (username: admin, password: Admin@12345)
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('Admin@12345'),
            'role' => 'admin',
            'must_change_password' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // system_settings
        $settings = [
            'school_name' => ['SMK Contoh Nusantara', 'Identitas rapor'],
            'default_weight_activity' => ['20', 'Bobot default nilai keaktifan (%)'],
            'default_weight_lesson' => ['40', 'Bobot default nilai pelajaran (%)'],
            'default_weight_exam' => ['40', 'Bobot default nilai CBT (%)'],
            'cbt_warning_limit' => ['5', 'Kelipatan peringatan untuk mengeluarkan siswa'],
            'cbt_long_exam_hours' => ['4', 'Batas jam yang memicu konfirmasi durasi panjang'],
        ];
        $rows = [];
        foreach ($settings as $key => [$value, $description]) {
            $rows[] = [
                'setting_key' => $key,
                'setting_value' => $value,
                'description' => $description,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('system_settings')->insert($rows);

        // majors
        DB::table('majors')->insert([
            ['name' => 'Rekayasa Perangkat Lunak', 'abbreviation' => 'RPL', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Teknik Komputer dan Jaringan', 'abbreviation' => 'TKJ', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Desain Komunikasi Visual', 'abbreviation' => 'DKV', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // subjects
        $subjects = [
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Pendidikan Agama', 'PPKn',
            'Sejarah Indonesia', 'Seni Budaya', 'PJOK', 'Informatika', 'Dasar Kejuruan',
        ];
        $rows = [];
        foreach ($subjects as $name) {
            $custom = $name === 'Matematika';
            $rows[] = [
                'name' => $name,
                'kkm' => 70,
                'weight_activity' => $custom ? 25 : null,
                'weight_lesson' => $custom ? 35 : null,
                'weight_exam' => $custom ? 40 : null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('subjects')->insert($rows);

        // academic_years dan semesters
        $yearId = DB::table('academic_years')->insertGetId([
            'name' => '2026/2027',
            'start_date' => '2026-07-13',
            'end_date' => '2027-06-26',
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('semesters')->insert([
            ['academic_year_id' => $yearId, 'type' => 'ganjil', 'start_date' => '2026-07-13', 'end_date' => '2026-12-19', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['academic_year_id' => $yearId, 'type' => 'genap', 'start_date' => '2027-01-04', 'end_date' => '2027-06-26', 'is_active' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // period_slots
        $slots = [
            [1, '07:00', '07:45', false, null],
            [2, '07:45', '08:30', false, null],
            [3, '08:30', '09:15', false, null],
            [4, '09:15', '10:00', false, null],
            [5, '10:00', '10:15', true, 'Istirahat 1'],
            [6, '10:15', '11:00', false, null],
            [7, '11:00', '11:45', false, null],
            [8, '11:45', '12:30', false, null],
            [9, '12:30', '13:00', true, 'Istirahat 2'],
            [10, '13:00', '13:45', false, null],
            [11, '13:45', '14:30', false, null],
        ];
        $rows = [];
        foreach ($slots as [$number, $start, $end, $isBreak, $label]) {
            $rows[] = [
                'slot_number' => $number,
                'start_time' => $start,
                'end_time' => $end,
                'is_break' => $isBreak,
                'label' => $label,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('period_slots')->insert($rows);
    }
}
