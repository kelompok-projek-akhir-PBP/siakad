<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'abbrevation', 'is_active'])]
class Major extends Model
{
    public function students(){
        return $this->hasMany(Student::class);
    }

    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }
}
