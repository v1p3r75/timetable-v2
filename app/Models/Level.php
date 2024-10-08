<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'label',
        'total_students'
    ];

    public function timetable() {

        return $this->hasOne(Timetable::class);
    }
}