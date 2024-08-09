@extends('Base.base')
 @section('title') Dashboard @endsection

 @section('content')

 <div class="my-3 d-grid grid-2 grid-lg-4 gap-2">
    <div class="card col border border-1 rounded-3 p-3 container-fluid shadow-sm border-0 animate__animated animate__fadeInDown">
    <div class="row row-cols-2 justify-content-between">
        <div class="info align-self-center">
            <h6 class="text-muted">Cours cette semaine</h6>
            <h5>{{ $totalClasses }}</h5>
        </div>
        <div>
            <div class="card-img p-2 text-center">
                <img src="{{ asset('/books.svg')}}" alt="student">
            </div>
        </div>
    </div>
    </div>
    <div class="card col border border-1 rounded-3 p-3 container-fluid shadow-sm border-0 animate__animated animate__fadeInUp">
    <div class="row row-cols-2 justify-content-between">
        <div class="info align-self-center">
            <h6 class="text-muted">Heures cette semaine</h6>
            <h5>{{ $totalHours }}h</h5>
        </div>
        <div>
            <div class="card-img p-2 text-center">
                <img src="{{ asset('/dash-icon-01.svg')}}" alt="student">
            </div>
        </div>
    </div>
    </div>
    <div class="card col border border-1 rounded-3 p-3 container-fluid shadow-sm border-0 animate__animated animate__fadeInDown">
    <div class="row row-cols-2 justify-content-between">
        <div class="info align-self-center">
            <h6 class="text-muted">Le plus chargé</h6>
            <h5>{{ $mostBusyDay }}</h5>
        </div>
        <div>
            <div class="card-img p-2 text-center">
                <img src="{{ asset('books.svg')}}" alt="student">
            </div>
        </div>
    </div>
    </div>
    <div class="card col border border-1 rounded-3 p-3 container-fluid shadow-sm border-0 animate__animated animate__fadeInUp">
    <div class="row row-cols-2 justify-content-between">
        <div class="info align-self-center">
            <h6 class="text-muted">Le moins chargé</h6>
            <h5>{{ $leastBusyDay }}</h5>
        </div>
        <div>
            <div class="card-img p-2 text-center">
                <img src="{{  asset('/dash-icon-03.svg')}}" alt="">
            </div>
        </div>
    </div>
    </div>
    </div>
 @endsection