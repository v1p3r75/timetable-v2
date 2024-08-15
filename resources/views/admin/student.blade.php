@extends('Base.base')
 @section('title') Les élèves @endsection

 @section('content') 
 <div class="margin-update">
 <div class="table-responsive mt-5 animate__animated animate__zoomIn">
    <table class="table table-striped shadow-sm w-100" id="myTable">
        <thead class="bg-white">
            <tr>
                <th>Profile</th>
                <th>Nom</th>
                <th>Prénom(s)</th>
                <th>Matricule</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Sexe</th>
                <th>Naissance</th>
                <th class="">Actions</th>
            </tr>
        </thead>
        <tbody>
                {{-- @dd($teachers) --}}
                @foreach ($students as $student)
                <tr>
                <td><img src="{{ $student->storageUrl() }}" alt="" style="width: width: 36px;height: 36px;object-fit: cover;border-radius: 50%; "></td>
                <td>{{ $student->lastname }}</td>
                <td>{{ $student->firstname }}</td>
                <td>{{ $student->serial_number }}</td>
                <td>{{ $student->phone }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->sex === "M" ? "Masculin" : "Féminin" }}</td>
                <td>{{ $student->birthday ? (new DateTime($student->birthday))->format('d/m/Y') : "" }}</td>
                <td>
                    <div class="d-flex justify-content-center align-items-center w-100 gap-1 ">
                            <form action="{{ route('student.destroy', $student) }}" method="post" class="delete-form">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger rounded-1 btn-action delete-btn p-3">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                            <form action="{{ route('student.blocked', $student) }}" method="post">
                                @csrf
                                
                                @if ($student->blocked)
                                <button class="btn btn-danger rounded-1"><i class="bx bxs-lock"></i></button>
                                @else
                                <button class="btn btn-primary"><i class="bx bxs-lock-open"></i></button>
                                @endif
                            </form>
                    </div>
                </td>
            </tr>
                @endforeach
            
        </tbody>
   </table>
 </div>
 @endsection