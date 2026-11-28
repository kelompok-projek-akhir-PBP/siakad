<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lms_task_id', 'student_id', 'submitted_at', 'correct_count', 'total_questions', 'score'])]
class LmsTaskSubmission extends Model
{
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    public function lms_task()
    {
        return $this->belongsTo(LmsTask::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function answers()
    {
        return $this->hasMany(LmsTaskAnswer::class);
    }
}