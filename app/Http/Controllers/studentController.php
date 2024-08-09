<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;


class StudentController extends Controller
{
    public function index()
    {
        $students = User::query() ;
        $students->where('role_id', '=', Role::STUDENT);
        return view('admin.student',[ 'students' =>   $students->get()] );
    }
    public function blocked(User $student)
     {
            if ( $student->isblocked() ){
                $student->blocked = false ;
                $student->save();
                toastr()->success("L'étudiant à été débloquer avec success") ;
            }else{
                $student->blocked = true ;
                $student->save();
                toastr()->success("L'étudiant à été bloquer avec success") ;
            }
        
        return redirect()->route('student.index');
    }

}
