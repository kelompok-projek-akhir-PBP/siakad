<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class LmsSeeder extends DummySeeder
{
    public function run(): void
    {
        $now = now();
        $assignments = DB::table('teaching_assignments')
            ->join('subjects', 'subjects.id', '=', 'teaching_assignments.subject_id')
            ->orderBy('teaching_assignments.id')
            ->get([
                'teaching_assignments.id',
                'teaching_assignments.classroom_id',
                'teaching_assignments.teacher_id',
                'subjects.name as subject_name',
            ]);
        $studentsByClass = DB::table('class_enrollments')
            ->get(['student_id', 'classroom_id'])
            ->groupBy('classroom_id');
        $studentUsers = DB::table('students')->pluck('user_id', 'id')->all();

        // learning_materials 
        $rows = [];
        foreach ($assignments as $a) {
            $rows[] = [
                'teaching_assignment_id' => $a->id,
                'title' => 'Materi Pertemuan 1 - '.$a->subject_name,
                'body' => 'Ringkasan materi pertemuan pertama untuk mata pelajaran '.$a->subject_name.'. (data dummy)',
                'created_by_teacher_id' => $a->teacher_id,
                'published_at' => '2026-11-10 08:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('learning_materials')->insert($rows);
        $materialIds = DB::table('learning_materials')->orderBy('id')->pluck('id')->all();

        // material_attachments
        $rows = [];
        foreach ($materialIds as $i => $materialId) {
            if ($i % 2 === 0) {
                $rows[] = [
                    'learning_material_id' => $materialId,
                    'type' => 'file',
                    'title' => 'Modul Pertemuan 1',
                    'file_path' => 'uploads/materials/dummy-'.$materialId.'.pdf',
                    'original_name' => 'modul-pertemuan-1.pdf',
                    'file_size' => 250000,
                    'url' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            } else {
                $rows[] = [
                    'learning_material_id' => $materialId,
                    'type' => 'link',
                    'title' => 'Video Pembelajaran',
                    'file_path' => null,
                    'original_name' => null,
                    'file_size' => null,
                    'url' => 'https://example.com/video/'.$materialId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('material_attachments')->insert($rows);

        // lms_tasks
        $rows = [];
        foreach ($assignments as $a) {
            $rows[] = [
                'teaching_assignment_id' => $a->id,
                'title' => 'Tugas 1 - '.$a->subject_name,
                'description' => 'Kerjakan soal pilihan ganda berikut dengan teliti. (data dummy)',
                'due_at' => '2026-11-20 23:59:00',
                'created_by_teacher_id' => $a->teacher_id,
                'published_at' => '2026-11-12 08:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('lms_tasks')->insert($rows);
        $taskIds = DB::table('lms_tasks')->orderBy('id')->pluck('id')->all();

        // lms_task_questions
        $rows = [];
        foreach ($taskIds as $taskId) {
            for ($n = 1; $n <= 5; $n++) {
                $rows[] = [
                    'lms_task_id' => $taskId,
                    'question_text' => 'Soal nomor '.$n.' (data dummy). Pilih jawaban yang paling tepat.',
                    'sort_order' => $n,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('lms_task_questions', $rows);
        $questions = DB::table('lms_task_questions')->orderBy('id')->get(['id', 'lms_task_id']);

        // lms_task_options
        $rows = [];
        foreach ($questions as $q) {
            $correct = $q->id % 4;
            foreach (['A', 'B', 'C', 'D'] as $k => $label) {
                $rows[] = [
                    'lms_task_question_id' => $q->id,
                    'option_text' => 'Pilihan '.$label,
                    'is_correct' => $k === $correct,
                    'sort_order' => $k + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('lms_task_options', $rows);

        $optionsByQuestion = DB::table('lms_task_options')
            ->orderBy('id')
            ->get(['id', 'lms_task_question_id', 'is_correct'])
            ->groupBy('lms_task_question_id');
        $questionsByTask = $questions->groupBy('lms_task_id');

        // lms_task_submissions + lms_task_answers
        $pendingAnswers = [];
        $submissionRows = [];
        foreach ($assignments as $i => $a) {
            $taskId = $taskIds[$i];
            foreach ($studentsByClass[$a->classroom_id] ?? [] as $en) {
                if (mt_rand(1, 100) > 85) {
                    continue; 
                }

                $answers = [];
                $correctCount = 0;
                foreach ($questionsByTask[$taskId] as $q) {
                    $options = $optionsByQuestion[$q->id];
                    $right = $options->first(fn ($o) => (bool) $o->is_correct);
                    $chosen = mt_rand(1, 100) <= 70
                        ? $right
                        : $options->reject(fn ($o) => (bool) $o->is_correct)->random();
                    $isCorrect = $chosen->id === $right->id;
                    if ($isCorrect) {
                        $correctCount++;
                    }
                    $answers[] = [
                        'lms_task_question_id' => $q->id,
                        'selected_option_id' => $chosen->id,
                        'is_correct' => $isCorrect,
                    ];
                }

                $total = count($answers);
                $pendingAnswers[$taskId.'|'.$en->student_id] = $answers;
                $submissionRows[] = [
                    'lms_task_id' => $taskId,
                    'student_id' => $en->student_id,
                    'submitted_at' => Carbon::parse('2026-11-12 09:00:00')->addMinutes(mt_rand(0, 11000))->toDateTimeString(),
                    'correct_count' => $correctCount,
                    'total_questions' => $total,
                    'score' => round($correctCount / $total * 100, 2),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('lms_task_submissions', $submissionRows);

        $answerRows = [];
        foreach (DB::table('lms_task_submissions')->get(['id', 'lms_task_id', 'student_id']) as $sub) {
            foreach ($pendingAnswers[$sub->lms_task_id.'|'.$sub->student_id] as $answer) {
                $answerRows[] = array_merge(['lms_task_submission_id' => $sub->id], $answer, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
        $this->insertChunked('lms_task_answers', $answerRows);

        // notifications
        $firstIndexByClass = [];
        foreach ($assignments as $i => $a) {
            $firstIndexByClass[$a->classroom_id] ??= $i;
        }
        $rows = [];
        foreach ($studentsByClass as $classroomId => $enrollments) {
            $i = $firstIndexByClass[$classroomId];
            foreach ($enrollments as $en) {
                $userId = $studentUsers[$en->student_id];
                $rows[] = [
                    'user_id' => $userId,
                    'type' => 'materi_baru',
                    'title' => 'Materi baru',
                    'message' => 'Guru membagikan materi baru di ruang pembelajaran kamu.',
                    'ref_type' => 'learning_material',
                    'ref_id' => $materialIds[$i],
                    'read_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $rows[] = [
                    'user_id' => $userId,
                    'type' => 'tugas_baru',
                    'title' => 'Tugas baru',
                    'message' => 'Ada tugas baru dengan tenggat 20 November 2026.',
                    'ref_type' => 'lms_task',
                    'ref_id' => $taskIds[$i],
                    'read_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('notifications', $rows);
    }
}
