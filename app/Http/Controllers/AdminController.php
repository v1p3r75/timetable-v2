<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Level;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        
        return view('admin.dashboard', [

            'admins' => User::whereBetween('role_id', [Role::CENSOR, role::DEPUTY_CENSOR])->get()->count(),
            'levels' => Level::all()->count(),
            'classrooms' => Classroom::all()->count(),
            'timetables' => Timetable::all()->count(),
            'subjects' => Subject::all()->count(),
            'teachers' => User::where('role_id', Role::TEACHER)->get()->count(),
            'students' => User::where('role_id', Role::STUDENT)->get()->count()
        ]);
    }
    
}
