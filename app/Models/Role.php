<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const CENSOR = 1200;

    const DEPUTY_CENSOR = 1201;

    const DIRECTOR = 1300;

    const TEACHER = 1400;

    const STUDENT = 1500;

    protected $fillable = ['label', 'role'];

}
