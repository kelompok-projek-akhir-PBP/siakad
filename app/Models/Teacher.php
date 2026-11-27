<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'nip', 'name', 'gender', 'birth_place', 'birth_date', 'phone', 'status'])]
class Teacher extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function teaching_assignments(){
        return $this->hasMany(TeachingAssignment::class);
    }
}
