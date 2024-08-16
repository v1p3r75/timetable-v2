@extends('Base.base')
@section('title', $teacher->exists ? "Modifier un professeur" : "Créer un professeur") 
@section('content')
    <form action="{{ route($teacher->exists ? 'teacher.update' : 'teacher.store' , $teacher) }}" method="post" class="p-4 margin-update">
        @method($teacher->exists ? 'PATCH' : 'POST')
        @csrf
        <h5 class="">
            @if ($teacher->exists)
            Modifier un professeur
         @else
            Créer un professeur
         @endif
        </h5>
        <div class="row ">
            <div class="col-md-6">
                <label for="teacherinput" class="mt-2">Prénom(s)</label>
                <input type="text" id="teacherinput" name="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname',$teacher->firstname) }}">
                <div class="invalid-feedback">
                    @error('firstname')
                       {{ $message }} 
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="teacherinput" class="mt-2">Nom</label>
                <input type="text" id="teacherinput" name="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname',$teacher->lastname) }}">
                <div class="invalid-feedback">
                    @error('lastname')
                       {{ $message }} 
                    @enderror
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-6">
                <label for="teacherinput" class="mt-2">Email</label>
                <input type="email" id="teacherinput" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$teacher->email) }}">
                <div class="invalid-feedback">
                    @error('email')
                       {{ $message }} 
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="teacherinput" class="mt-2">Phone</label>
                <input type="text" id="teacherinput" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$teacher->phone) }}">
                <div class="invalid-feedback">
                    @error('phone')
                       {{ $message }} 
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="teacherinput" class="mt-2">Matricule</label>
                <input type="text" id="teacherinput" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror" value="{{ old('serial_number',$teacher->serial_number) }}">
                <div class="invalid-feedback">
                    @error('serial_number')
                       {{ $message }} 
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="teacherinput" class="mt-2">Sexe</label>
                <select id="timetableinput" name="sex" class="form-control @error('classroom') is-invalid @enderror">
                    <option value="">Choisir le sexe</option>
                    @foreach(['M' => 'Masculin', 'F' => 'Féminin'] as $key => $item)
                    <option value="{{ $key }}" @selected(old('sex', $teacher->sex ===
                        $key))>{{ $item }}</option>
                    @endforeach
                </select>                
                <div class="invalid-feedback">
                    @error('sex')
                       {{ $message }} 
                    @enderror
                </div>
            </div>
            <div class="col-md-4 form-group">
                <label for="birthday" class="mt-2">Date de naissance</label>
                <input type="date" name="birthday" class="mb-2 form-control input-custom @error('birthday') is-invalid @enderror" value="{{ old('birthday',$teacher->birthday) }}">
                @error('birthday')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                @enderror
            </div>
        </div>
            <div class="">
                <button class="btn btn-primary shadow mt-2">
                    @if ($teacher->exists)
                        Modifier   
                    @else
                        Créer
                    @endif
                </button>
            </div>
       
    </form>
@endsection