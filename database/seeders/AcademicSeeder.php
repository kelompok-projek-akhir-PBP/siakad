<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

class AcademicSeeder extends DummySeeder
{
    public function run(): void
    {
        $now = now();
        $yearId = DB::table('academic_years')->where('is_active', true)->value('id');
        $semesterId = DB::table('semesters')->where('is_active', true)->value('id');
        $genapId = DB::table('semesters')->where('type', 'genap')->value('id');
        $majors = DB::table('majors')->pluck('id', 'abbreviation')->all();
        $layout = PeopleSeeder::CLASS_LAYOUT;

        // class_configurations
        $counts = [];
        foreach ($layout as [$abbr, $number]) {
            $counts[$abbr] = ($counts[$abbr] ?? 0) + 1;
        }
        $rows = [];
        foreach ($counts as $abbr => $count) {
            $rows[] = [
                'academic_year_id' => $yearId,
                'major_id' => $majors[$abbr],
                'grade_level' => 10,
                'class_count' => $count,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('class_configurations')->insert($rows);

        // classrooms
        $rows = [];
        foreach ($layout as [$abbr, $number]) {
            $rows[] = [
                'academic_year_id' => $yearId,
                'major_id' => $majors[$abbr],
                'grade_level' => 10,
                'class_number' => $number,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('classrooms')->insert($rows);
        $classroomIds = DB::table('classrooms')->orderBy('id')->pluck('id')->all();

        // class_enrollments
        $studentIds = DB::table('students')->orderBy('id')->pluck('id')->all();
        $rows = [];
        foreach ($studentIds as $i => $studentId) {
            $rows[] = [
                'student_id' => $studentId,
                'classroom_id' => $classroomIds[$i % count($classroomIds)],
                'academic_year_id' => $yearId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->insertChunked('class_enrollments', $rows);

        // teaching_assignments
        $subjectIds = DB::table('subjects')->orderBy('id')->pluck('id')->all();
        $teacherIds = DB::table('teachers')->orderBy('id')->pluck('id')->all();
        $rows = [];
        foreach ($classroomIds as $classroomId) {
            foreach ($subjectIds as $s => $subjectId) {
                $rows[] = [
                    'semester_id' => $semesterId,
                    'classroom_id' => $classroomId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherIds[$s % count($teacherIds)],
                    'weekly_jp_target' => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('teaching_assignments')->insert($rows);

        // homeroom_assignments
        $rows = [];
        foreach ($classroomIds as $c => $classroomId) {
            $rows[] = [
                'academic_year_id' => $yearId,
                'classroom_id' => $classroomId,
                'teacher_id' => $teacherIds[$c % count($teacherIds)],
                'assigned_at' => '2026-07-13 07:00:00',
                'ended_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('homeroom_assignments')->insert($rows);

        // schedules
        $slotIds = DB::table('period_slots')->pluck('id', 'slot_number')->all();
        $blocks = [[1, 2], [3, 4], [6, 7], [10, 11]]; // blok 2 JP berurutan, tidak melewati istirahat
        $classIndex = array_flip($classroomIds);
        $subjectIndex = array_flip($subjectIds);
        $assignments = DB::table('teaching_assignments')->orderBy('id')->get(['id', 'classroom_id', 'subject_id']);
        $rows = [];
        foreach ($assignments as $a) {
            $p = ($subjectIndex[$a->subject_id] + 2 * $classIndex[$a->classroom_id]) % 20;
            [$start, $end] = $blocks[$p % 4];
            $rows[] = [
                'teaching_assignment_id' => $a->id,
                'day_of_week' => intdiv($p, 4) + 1,
                'start_slot_id' => $slotIds[$start],
                'end_slot_id' => $slotIds[$end],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('schedules')->insert($rows);

        // promotion_decisions
        $enrollments = DB::table('class_enrollments')->orderBy('id')->limit(5)->get(['id', 'classroom_id']);
        $alpa = [0.00, 2.50, 8.33, 16.67, 4.00];
        $rows = [];
        foreach ($enrollments as $i => $e) {
            $tooMuch = $alpa[$i] > 15;
            $rows[] = [
                'class_enrollment_id' => $e->id,
                'semester_id' => $genapId,
                'system_recommendation' => $tooMuch ? 'tidak_direkomendasikan' : 'direkomendasikan',
                'alpa_percentage' => $alpa[$i],
                'final_decision' => $tooMuch ? 'tidak_naik_kelas' : 'naik_kelas',
                'decided_by_teacher_id' => $teacherIds[$classIndex[$e->classroom_id] % count($teacherIds)],
                'decided_at' => $now,
                'corrected_by_user_id' => null,
                'corrected_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('promotion_decisions')->insert($rows);
    }
}
