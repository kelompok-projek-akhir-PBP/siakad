<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lms_task_id', 'question_text', 'sort_order'])]
class LmsTaskQuestion extends Model
{
    public function lms_task()
    {
        return $this->belongsTo(LmsTask::class);
    }

    public function options()
    {
        return $this->hasMany(LmsTaskOption::class);
    }
}