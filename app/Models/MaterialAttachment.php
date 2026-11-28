<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['learning_material_id', 'type', 'title', 'file_path', 'original_name', 'file_size', 'url'])]
class MaterialAttachment extends Model
{
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function learning_material()
    {
        return $this->belongsTo(LearningMaterial::class);
    }
}