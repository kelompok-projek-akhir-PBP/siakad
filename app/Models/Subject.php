<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'kkm', 'weight_activity', 'weight_lesson', 'weight_exam', 'is_active'])]
class Subject extends Model
{
    public function teaching_assignments(){
        return $this->hasMany(TeachingAssignment::class);
    }
}
