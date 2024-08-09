<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollaboratorRequest;
use App\Http\Requests\CollaboratorUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Hash;
use Str;

class CollaboratorController extends Controller
{
    public function index()
    {
        $collaborators = User::query();
        $collaborators->whereBetween('role_id', [Role::CENSOR, role::DEPUTY_CENSOR]);
        return view('admin.collaborator', ['collaborators' =>   $collaborators->get()]);
    }
    public function create()
    {
        return view('admin.form.collaborator', ['collaborator' => new User()]);
    }
    public function store(CollaboratorRequest $request)
    {
        $collaborator = new User();
        $collaborator = $collaborator->create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'serial_number' => $request->serial_number,
            'role_id' => Role::DEPUTY_CENSOR,
            'password' => Hash::make(Str::random(8)),
        ]);

        /* envoyer un mail au collaborateur pour quil met a jour son compte */

        toastr()->success("Le collaborateur à été créer avec succès !");
        return redirect()->route('collaborator.index');
    }
    public function edit(User $collaborator)
    {
        return view('admin.form.collaborator', ['collaborator' => $collaborator]);
    }
    public function update(User $collaborator, CollaboratorUpdateRequest $request)
    {
        $collaborators = $collaborator->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'serial_number' => $request->serial_number,
            'role_id' => Role::DEPUTY_CENSOR,

        ]);
        toastr()->success("Le collaborateur à été mise à jour avec succès !");
        return redirect()->route('collaborator.index');
    }
    public function destroy(User $collaborator)
    {
        $collaborator = $collaborator->delete();
        toastr()->success("Le collaborateur à été supprimer avec succès  !");
        return redirect()->route('collaborator.index');
    }
}
