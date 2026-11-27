<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'start_date', 'end_date', 'is_active'])]
class AcademicYear extends Model {
    public function semesters(){
        return $this->hasMany(Semester::class);
    }

    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }

    public function class_enrollments(){
        return $this->hasMany(ClassEnrollment::class);
    }
}
