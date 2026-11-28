<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['teaching_assignment_id', 'title', 'description', 'due_at', 'created_by_teacher_id', 'published_at'])]
class LmsTask extends Model
{
    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function teaching_assignment()
    {
        return $this->belongsTo(TeachingAssignment::class);
    }

    public function creator()
    {
        return $this->belongsTo(Teacher::class, 'created_by_teacher_id');
    }

    public function questions()
    {
        return $this->hasMany(LmsTaskQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(LmsTaskSubmission::class);
    }
}