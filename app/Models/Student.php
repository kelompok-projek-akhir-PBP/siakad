<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'nis', 'name', 'gender', 'birth_place', 'birth_date', 'phone', 'major_id', 'status'])]
class Student extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function major(){
        return $this->belongsTo(Major::class);
    }

    public function class_enrollments(){
        return $this->hasMany(ClassEnrollment::class);
    }
}
