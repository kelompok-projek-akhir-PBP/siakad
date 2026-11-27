<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['academic_year_id', 'major_id', 'grade_level', 'class_number'])]
class Classroom extends Model
{
    public function academic_year(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function major(){
        return $this->belongsTo(Major::class);
    }

    public function class_enrollments(){
        return $this->hasMany(ClassEnrollment::class);
    }

    public function teaching_assignments(){
        return $this->hasMany(TeachingAssignment::class);
    }
}
