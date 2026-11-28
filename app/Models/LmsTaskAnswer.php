<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lms_task_submission_id', 'lms_task_question_id', 'selected_option_id', 'is_correct'])]
class LmsTaskAnswer extends Model
{
    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(LmsTaskSubmission::class, 'lms_task_submission_id');
    }

    public function question()
    {
        return $this->belongsTo(LmsTaskQuestion::class, 'lms_task_question_id');
    }

    public function selected_option()
    {
        return $this->belongsTo(LmsTaskOption::class, 'selected_option_id');
    }
}