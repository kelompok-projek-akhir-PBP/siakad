<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['semester_id', 'classroom_id', 'subject_id', 'teacher_id', 'weekly_jp_target'])]
class TeachingAssignment extends Model
{
    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
}
