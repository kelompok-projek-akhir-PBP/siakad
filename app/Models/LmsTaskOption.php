<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lms_task_question_id', 'option_text', 'is_correct', 'sort_order'])]
class LmsTaskOption extends Model
{
    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    public function question()
    {
        return $this->belongsTo(LmsTaskQuestion::class, 'lms_task_question_id');
    }
}