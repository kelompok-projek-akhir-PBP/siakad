<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['teaching_assignment_id', 'title', 'body', 'created_by_teacher_id', 'published_at'])]
class LearningMaterial extends Model
{
    protected function casts(): array
    {
        return [
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

    public function attachments()
    {
        return $this->hasMany(MaterialAttachment::class);
    }
}