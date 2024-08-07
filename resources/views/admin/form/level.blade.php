@extends('Base.base')
@section('title', $level->exists ? "Modifier un niveau" : "Créer un niveau")
@section('content')
<form action="{{ route($level->exists ? 'level.update' : 'level.store' , $level) }}" method="post" class="p-4 margin-update">
    @method($level->exists ? 'PATCH' : 'POST')
    @csrf
    <h5 class="">
        @if ($level->exists)
        Modifier un niveau
        @else
        Créer un niveau
        @endif
    </h5>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <label for="levelinput" class="mt-2">Nom</label>
            <input type="text" id="levelinput" name="label" class="form-control @error('label'): is-invalid @enderror" value="{{ old('label',$level->label) }}">
            <div class="invalid-feedback">
                @error('label')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <label for="levelinput" class="mt-2">Efféctif</label>
            <input type="text" id="levelinput" name="total_students" class="form-control @error('total_students'): is-invalid @enderror" value="{{ old('total_students',$level->total_students) }}">
            <div class="invalid-feedback">
                @error('total_students')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary shadow  mt-2">
            @if ($level->exists)
            Modifier
            @else
            Créer
            @endif
        </button>
    </div>
</form>
@endsection