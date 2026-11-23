<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class AttendanceGradeSeeder extends DummySeeder
{
    public function run(): void
    {
        $now = now();
        $teacherUsers = DB::table('teachers')->pluck('user_id', 'id')->all();
        $studentsByClass = DB::table('class_enrollments')
            ->get(['student_id', 'classroom_id'])
            ->groupBy('classroom_id');

        // attendance_sessions
        $schedules = DB::table('schedules')
            ->join('teaching_assignments as ta', 'ta.id', '=', 'schedules.teaching_assignment_id')
            ->get(['schedules.id as schedule_id', 'schedules.day_of_week', 'ta.classroom_id', 'ta.teacher_id']);

        $mondays = ['2026-11-09', '2026-11-16'];
        $rows = [];
        foreach ($schedules as $sc) {
            foreach ($mondays as $monday) {
                $rows[] = [
                    'schedule_id' => $sc->schedule_id,
                    'session_date' => Carbon::parse($monday)->addDays($sc->day_of_week - 1)->toDateString(),
                    'teacher_id' => $sc->teacher_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('attendance_sessions', $rows);

        $sessionIds = [];
        foreach (DB::table('attendance_sessions')->get(['id', 'schedule_id', 'session_date']) as $s) {
            $sessionIds[$s->schedule_id.'|'.$s->session_date] = $s->id;
        }

        // attendance_records
        $records = [];
        foreach ($schedules as $sc) {
            foreach ($mondays as $monday) {
                $date = Carbon::parse($monday)->addDays($sc->day_of_week - 1)->toDateString();
                $sessionId = $sessionIds[$sc->schedule_id.'|'.$date];
                foreach ($studentsByClass[$sc->classroom_id] ?? [] as $en) {
                    $r = mt_rand(1, 100);
                    $status = $r <= 88 ? 'hadir' : ($r <= 93 ? 'sakit' : ($r <= 97 ? 'izin' : 'alpa'));
                    $records[] = [
                        'attendance_session_id' => $sessionId,
                        'student_id' => $en->student_id,
                        'status' => $status,
                        'note' => $status === 'hadir' ? null : 'Data dummy',
                        'updated_by_user_id' => $teacherUsers[$sc->teacher_id],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }
        $this->insertChunked('attendance_records', $records);

        // student_grades
        $assignments = DB::table('teaching_assignments')->orderBy('id')->get(['id', 'classroom_id', 'teacher_id']);
        $rows = [];
        foreach ($assignments as $a) {
            foreach ($studentsByClass[$a->classroom_id] ?? [] as $en) {
                $rows[] = [
                    'teaching_assignment_id' => $a->id,
                    'student_id' => $en->student_id,
                    'activity_score' => mt_rand(6000, 10000) / 100,
                    'lesson_score' => mt_rand(5500, 10000) / 100,
                    'updated_by_user_id' => $teacherUsers[$a->teacher_id],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('student_grades', $rows);
    }
}
