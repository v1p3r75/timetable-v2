@extends('Base.base')
@section('title') Les emploi du temps @endsection

@section('content')
<div class="margin-update">
    <div class="d-flex justify-content-end mb-2 align-items-center">
        <a class='btn btn-primary text-center shadow' href="{{ route('timetable.create') }}">Ajouter</a>
    </div>
    <div class="table-responsive mt-5 animate__animated animate__zoomIn">
        <table class="table table-striped shadow-sm w-100" id="myTable">
            <thead class="bg-white text-center">
                <tr>
                    <th>#</th>
                    <th>Classe</th>
                    <th>Salle de cours</th>
                    <th class="">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($teachers) --}}
                @foreach ($timetables as $key => $timetable)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $timetable->level->label}}</td>
                    <td>{{ $timetable->classroom->label}}</td>
                    <td class="">
                        <div class="d-flex justify-content-center align-items-center w-100 gap-1 ">
                            <button class="btn btn-primary rounded-1 btn-action" title="Voir">
                                <i class="bx bx-view"></i>
                            </button>
                            <a title="Editer" href="{{ route('timetable.edit', $timetable) }}" class="btn btn-primary rounded-1 text-light btn-action "><i class="bx bx-edit"></i></a>
                            <button class="btn btn-danger rounded-1 btn-action delete-btn" title="Supprimer">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('timetable.destroy', $timetable) }}" method="post" class="delete-form">
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection