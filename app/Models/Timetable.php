<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    use HasFactory;

        public function classroom() : BelongsTo
        {
            return $this->belongsTo(classroom::class);
        }
        public function level() : BelongsTo
        {
            return $this->belongsTo(Level::class);
        }
    protected $fillable = [
        'classroom_id', 'level_id',
    ];
}
