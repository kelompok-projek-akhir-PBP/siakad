<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['student_id', 'classroom_id', 'academic_year_id'])]
class ClassEnrollment extends Model
{
    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class);
    }
}
