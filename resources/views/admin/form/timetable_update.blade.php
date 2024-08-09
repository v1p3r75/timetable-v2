@extends('Base.base')
@section('title', "Modifier un empoi du temps")
@section('content')
<form class="timetable-form p-4 margin-update">
    @csrf
    <h5>Modifier un emploi du temps</h5>
    <div class="row">
        <input type="hidden" name="id" value="{{ $timetable->id }}">
        <div class="col-md-6">
            <label for="timetableinput" class="mt-2">Classe</label>
            <select id="timetableinput" name="level" class="form-control @error('level') is-invalid @enderror">
                <option value="">Choisir une classe</option>
                @foreach($levels as $level )
                <option value="{{ $level->id }}" @selected($timetable->level->id === $level->id)>{{
                    $level->label }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                @error('level')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <label for="timetableinput" class="mt-2">Salle</label>
            <select id="timetableinput" name="classroom" class="form-control @error('classroom') is-invalid @enderror">
                <option value="">Choisir une salle</option>
                @foreach($classrooms as $classroom)
                <option value="{{ $classroom->id }}" @selected(old('classroom',$timetable->classroom->id ===
                    $classroom->id))>{{ $classroom->label }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                @error('classroom')
                {{ $message }}
                @enderror
            </div>
        </div>

    </div>
    <div class="mt-4 groups">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach ($days as $key => $day)
            <div class="accordion-item">
                <h2 class="accordion-header" id={{ $day . "-heading"}}>
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target={{ "#" . $day }} aria-expanded="true" aria-controls="{{ $day }}">
                        {{ $day }}
                    </button>
                </h2>
                <div id={{$day}} class="accordion-collapse collapse" aria-labelledby={{ $day . "-heading"}} data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="group">
                            <div class="d-flex justify-content-end">
                                <div class="btn btn-outline-primary add-timetable" title="Ajouter un emploi" data-timetable-id="{{$key}}">
                                    <i class="bx bx-plus"></i>
                                </div>
                            </div>
                            @foreach ($timetable_days as $timetable)
                            @if ($timetable->day === $key)
                            <div class="template-form">
                                <input type="hidden" name="day[]" value="{{$timetable->day}}" />
                                <input type="hidden" name="timetable_id[]" value="{{ $timetable->id }}">
                                <div class="row content">
                                    <div class="col-md-6">
                                        <label for="timetableinput" class="mt-2">Heure de début</label>
                                        <input type="time" id="timetableinput" name="start_time[]" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', (new DateTime($timetable->start_time))->format('H:i') )}}">
                                        <div class="invalid-feedback">
                                            @error('start_time')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="timetableinput" class="mt-2">Heure de fin</label>
                                        <input type="time" id="timetableinput" name="end_time[]" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', (new DateTime($timetable->end_time))->format('H:i')) }}">
                                        <div class="invalid-feedback">
                                            @error('end_time')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="timetableinput" class="mt-2">Professeur</label>
                                        <select id="timetableinput" name="teacher[]" class="form-control @error('teacher') is-invalid @enderror">
                                            <option value="">Choisir un professeur</option>
                                            @foreach($teachers as $teacher )
                                            <option value="{{ $teacher->id }}" @selected(old('teacher',$timetable->user->id === $teacher->id))>{{ $teacher->lastname }} {{
                                                $teacher->firstname }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('teacher')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="timetableinput" class="mt-2">Cours</label>
                                        <select id="timetableinput" name="subject[]" class="form-control @error('subject') is-invalid @enderror">
                                            <option value="">Choisir une matière</option>
                                            @foreach($subjects as $subject )
                                            <option value="{{ $subject->id }}" @selected( old('subject',$timetable->subject_id === $subject->id))>{{ $subject->label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('subject')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="btn btn-outline-danger delete-timetable" title="Supprimer cet emploi">
                                        <i class="bx bx-trash"></i>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>

        <div class="mt-5">
            <button type="submit" class="btn btn-primary shadow mt-2 send-form" data-form-type="edit">Modifier</button>
        </div>

</form>
<template id="template">
    <div class="template-form">
        <input type="hidden" name="day[]" value="" />
        <input type="hidden" name="timetable_id[]" value="null">
        <div class="row content">
            <div class="col-md-6">
                <label for="timetableinput" class="mt-2">Heure de début</label>
                <input type="time" id="timetableinput" name="start_time[]" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time',$timetable->start_time) }}">
                <div class="invalid-feedback">
                    @error('start_time')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="timetableinput" class="mt-2">Heure de fin</label>
                <input type="time" id="timetableinput" name="end_time[]" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time',$timetable->end_time) }}">
                <div class="invalid-feedback">
                    @error('end_time')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="timetableinput" class="mt-2">Professeur</label>
                <select id="timetableinput" name="teacher[]" class="form-control @error('teacher') is-invalid @enderror">
                    <option value="">Choisir un professeur</option>
                    @foreach($teachers as $teacher )
                    <option value="{{ $teacher->id }}" @selected(old('teacher',$timetable->
                        user_id === $teacher->id))>{{ $teacher->lastname }} {{
                                                $teacher->firstname }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    @error('teacher')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="timetableinput" class="mt-2">Cours</label>
                <select id="timetableinput" name="subject[]" class="form-control @error('subject') is-invalid @enderror">
                    <option value="">Choisir une matière</option>
                    @foreach($subjects as $subject )
                    <option value="{{ $subject->id }}" @selected( old('subject',$timetable->
                        subject_id === $subject->id))>{{ $subject->label }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    @error('subject')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="btn btn-outline-danger delete-timetable" title="Supprimer cet emploi">
                <i class="bx bx-trash"></i>
            </div>
        </div>
        <hr>
    </div>
</template>

@endsection