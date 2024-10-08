<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = [
        'label','capacity','status','description',
    ];

    public function timetable() {

        return $this->hasOne(Timetable::class);
    }
}
