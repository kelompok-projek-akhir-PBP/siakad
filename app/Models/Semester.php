<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['academic_year_id','type', 'start_date', 'end_date', 'is_active'])]
class Semester extends Model
{
    public function academic_year(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function teaching_assignments(){
        return $this->hasMany(TeachingAssignment::class);
    }
}
