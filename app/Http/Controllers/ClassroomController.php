<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {

        return view('admin.classrooms', ['classrooms' => Classroom::all()]);
    }
    public function create()
    {
        return view('admin.form.classroom', ['classroom' => new Classroom()]);
    }
    public function store(ClassroomRequest $request)
    {
        $classroom = new Classroom();
        $data = $request->validated();
        $data['status'] = isset($request->status);

        $classroom = $classroom->create($data);

        toastr()->success("La salle de classe à été créer avec succès !");
        return redirect()->route('classroom.index');
    }
    public function edit(Classroom $classroom)
    {
        return view('admin.form.classroom', ['classroom' => $classroom]);
    }
    public function update(Classroom $classroom, ClassroomRequest $request)
    {
        $data = $request->validated();
        $data['status'] = isset($request->status);

        $classroom = $classroom->update($data);
        toastr()->success("La salle de classe à été mise à jour avec succès !");
        return redirect()->route('classroom.index');
    }
    public function destroy(Classroom $classroom)
    {
        $classroom = $classroom->delete();
        toastr()->success("La salle de classe à été supprimer avec succès  !");
        return redirect()->route('classroom.index');
    }
}
