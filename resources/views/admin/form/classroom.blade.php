@extends('Base.base')
@section('title', $classroom->exists ? "Modifier une salle de classe" : "Créer une salle de classe")
@section('content')
<form action="{{ route($classroom->exists ? 'classroom.update' : 'classroom.store' , $classroom) }}" method="post" class="p-4 margin-update">
    @method($classroom->exists ? 'PATCH' : 'POST')
    @csrf
    <h5 class="">
        @if ($classroom->exists)
        Modifier une salle de classe
        @else
        Créer une salle de classe
        @endif
    </h5>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <label for="classroominput" class="mt-2">Nom</label>
            <input type="text" id="classroominput" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label',$classroom->label) }}">
            <div class="invalid-feedbackF">
                @error('label')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <label for="classroominput" class="mt-2">Capacité</label>
            <input type="number" id="classroominput" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity',$classroom->capacity) }}">
            <div class="invalid-feedback">
                @error('capacity')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div class="row mt-2 d-flex justify-content-center">
        <div class="col-md-12">
            <label for="classroominput" class="mt-2">Description</label>
            <textarea type="text" placeholder="(Facultatif)" id="classroominput" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description',$classroom->description)  }}</textarea>
            <div class="invalid-feedback">
                @error('description')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div class="form-check form-switch mt-2">
        <input type="checkbox" name="status" id="status" class="form-check-input " @checked(old('status',$classroom->status)) >
        <label for="status" class="form-check-label"> Disponibilité</label>
    </div>
    <div class="">
        <button class="btn btn-primary shadow mt-4">
            @if ($classroom->exists)
            Modifier
            @else
            Créer
            @endif
        </button>
    </div>

    </div>
</form>
@endsection