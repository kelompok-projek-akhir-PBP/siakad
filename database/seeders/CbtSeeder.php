<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CbtSeeder extends DummySeeder
{
    public function run(): void
    {
        $now = now();
        $semesterId = DB::table('semesters')->where('is_active', true)->value('id');
        $adminId = DB::table('users')->where('username', 'admin')->value('id');
        $subjects = DB::table('subjects')->orderBy('id')->get(['id', 'name']);
        $classroomIds = DB::table('classrooms')->orderBy('id')->pluck('id')->all();
        $studentIds = DB::table('students')->orderBy('id')->pluck('id')->all();

        // exams 
        $rows = [];
        foreach ($subjects as $s) {
            $rows[] = [
                'semester_id' => $semesterId,
                'subject_id' => $s->id,
                'title' => 'UTS Ganjil '.$s->name,
                'category' => 'UTS',
                'open_at' => '2026-10-12 08:00:00',
                'close_at' => '2026-10-12 10:00:00',
                'token' => Str::upper(Str::random(6)),
                'token_updated_at' => '2026-10-10 15:00:00',
                'status' => 'diterbitkan',
                'results_announced_at' => '2026-10-14 10:00:00',
                'created_by_user_id' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        foreach ($subjects->take(3) as $s) {
            $rows[] = [
                'semester_id' => $semesterId,
                'subject_id' => $s->id,
                'title' => 'UAS Ganjil '.$s->name,
                'category' => 'UAS',
                'open_at' => '2026-12-07 08:00:00',
                'close_at' => '2026-12-07 10:00:00',
                'token' => Str::upper(Str::random(6)),
                'token_updated_at' => $now,
                'status' => 'draf',
                'results_announced_at' => null,
                'created_by_user_id' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('exams')->insert($rows);
        $exams = DB::table('exams')->orderBy('id')->get(['id', 'category', 'open_at', 'close_at']);

        // exam_classes
        $rows = [];
        foreach ($exams as $exam) {
            foreach ($classroomIds as $classroomId) {
                $rows[] = ['exam_id' => $exam->id, 'classroom_id' => $classroomId];
            }
        }
        $this->insertChunked('exam_classes', $rows);

        // exam_questions
        $rows = [];
        foreach ($exams as $exam) {
            for ($n = 1; $n <= 10; $n++) {
                $rows[] = [
                    'exam_id' => $exam->id,
                    'question_text' => 'Soal ujian nomor '.$n.' (data dummy). Pilih jawaban yang paling tepat.',
                    'sort_order' => $n,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('exam_questions', $rows);
        $questions = DB::table('exam_questions')->orderBy('id')->get(['id', 'exam_id']);

        // exam_question_options
        $rows = [];
        foreach ($questions as $q) {
            $correct = $q->id % 4;
            foreach (['A', 'B', 'C', 'D'] as $k => $label) {
                $rows[] = [
                    'exam_question_id' => $q->id,
                    'option_text' => 'Pilihan '.$label,
                    'is_correct' => $k === $correct,
                    'sort_order' => $k + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('exam_question_options', $rows);

        $optionsByQuestion = DB::table('exam_question_options')
            ->orderBy('id')
            ->get(['id', 'exam_question_id', 'is_correct'])
            ->groupBy('exam_question_id');
        $questionsByExam = $questions->groupBy('exam_id');

        // exam_attempts, exam_answers, exam_violations
        $pending = [];
        $attemptRows = [];
        foreach ($exams as $exam) {
            if ($exam->category !== 'UTS') {
                continue;
            }
            $open = Carbon::parse($exam->open_at);
            $close = Carbon::parse($exam->close_at);

            foreach ($studentIds as $studentId) {
                $started = $open->copy()->addMinutes(mt_rand(0, 20));
                $auto = mt_rand(1, 100) <= 10;
                $submitted = $auto ? $close->copy() : $started->copy()->addMinutes(mt_rand(45, 90));

                $answers = [];
                $correctCount = 0;
                foreach ($questionsByExam[$exam->id] as $q) {
                    $r = mt_rand(1, 100);
                    if ($r > 90) {
                        continue;
                    }
                    $options = $optionsByQuestion[$q->id];
                    $right = $options->first(fn ($o) => (bool) $o->is_correct);
                    $chosen = $r <= 70
                        ? $right
                        : $options->reject(fn ($o) => (bool) $o->is_correct)->random();
                    $isCorrect = $chosen->id === $right->id;
                    if ($isCorrect) {
                        $correctCount++;
                    }
                    $answers[] = [
                        'exam_question_id' => $q->id,
                        'selected_option_id' => $chosen->id,
                        'answered_at' => $started->copy()->addMinutes(mt_rand(1, 40))->toDateTimeString(),
                        'is_correct' => $isCorrect,
                    ];
                }

                $total = count($questionsByExam[$exam->id]);
                $violations = mt_rand(1, 100) <= 8 ? mt_rand(1, 6) : 0;

                $pending[$exam->id.'|'.$studentId] = [
                    'answers' => $answers,
                    'violations' => $violations,
                    'started' => $started,
                ];
                $attemptRows[] = [
                    'exam_id' => $exam->id,
                    'student_id' => $studentId,
                    'shuffle_seed' => mt_rand(1, 2147483647),
                    'started_at' => $started->toDateTimeString(),
                    'submitted_at' => $submitted->toDateTimeString(),
                    'submit_type' => $auto ? 'otomatis' : 'manual',
                    'correct_count' => $correctCount,
                    'total_questions' => $total,
                    'score' => round($correctCount / $total * 100, 2),
                    'is_locked' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('exam_attempts', $attemptRows);

        $answerRows = [];
        $violationRows = [];
        foreach (DB::table('exam_attempts')->get(['id', 'exam_id', 'student_id']) as $attempt) {
            $data = $pending[$attempt->exam_id.'|'.$attempt->student_id];

            foreach ($data['answers'] as $answer) {
                $answerRows[] = array_merge(['exam_attempt_id' => $attempt->id], $answer, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            for ($n = 0; $n < $data['violations']; $n++) {
                $violationRows[] = [
                    'exam_attempt_id' => $attempt->id,
                    'type' => $n % 2 === 0 ? 'halaman_tersembunyi' : 'keluar_fullscreen',
                    'occurred_at' => $data['started']->copy()->addMinutes(mt_rand(1, 40))->toDateTimeString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $this->insertChunked('exam_answers', $answerRows);
        $this->insertChunked('exam_violations', $violationRows);
    }
}
