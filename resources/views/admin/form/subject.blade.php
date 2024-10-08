@extends('Base.base')
@section('title', $subject->exists ? "Modifier une matière" : "Créer un matière")
@section('content')
<form action="{{ route($subject->exists ? 'subject.update' : 'subject.store' , $subject) }}" method="post" class="p-4 margin-update">
    @method($subject->exists ? 'PUT' : 'POST')
    @csrf
    <h5 class="">
        @if ($subject->exists)
        Modifier une matière
        @else
        Créer une matière
        @endif
    </h5>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 ">
            <label for="subjectinput" class="mt-2">Label</label>
            <input type="text" id="subjectinput" name="label" class="form-control @error('label') is-invalid @enderror" value="{{old('label', $subject->label)}}">
            <div class="invalid-feedback">
                @error('label')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-6 ">
            <label for="subjectinput" class="mt-2">Code</label>
            <input type="text" id="subjectinput" name="code" class="form-control @error('code') is-invalid @enderror" value="{{old('code', $subject->code)}}">
            <div class="invalid-feedback">
                @error('code')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-12">
            <label for="subjectinput" class="mt-2">Classe</label>
            <select name="level_id" id="" class="form-select @error('level_id') is-invalid @enderror">
                <option value="" disabled>Selectionner un level</option>
                @foreach ($levels as $level)
                <option value="{{ $level->id }}" @selected(old('level_id',$level->id === $subject->level_id))>{{ $level->label }}</option>
                @endforeach

            </select>

            <div class="invalid-feedback">
                @error('level_id')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-primary shadow mt-4">
            @if ($subject->exists)
            Modifier
            @else
            Créer
            @endif
        </button>
    </div>
</form>
@endsection