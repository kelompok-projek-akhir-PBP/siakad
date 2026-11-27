<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slot_number', 'start_time', 'end_time', 'is_break', 'label'])]
class PeriodSlot extends Model
{
    //
}
