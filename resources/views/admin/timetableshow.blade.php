@extends('Base.base')
 @section('title') Emploi du temps  @endsection

 @section('content')
 <div class="print">
  @if($timetable_days)
  <h6 class="d-flex align-items-center justify-content-center mt-3 my-5 text-muted">Emploi de la classe {{ $timetable->level->label }}</h6>
  <div>
      <div class="table-responsive">
        <table class="table table-default table-bordered">
          <thead>
            <tr>
              @foreach ($days as $day)
                <th scope="col">{{ $day }}</th>
                @endforeach
            </tr>
          </thead>
          <tbody>
            <tr class="">
              @foreach ($days as $key => $day)
                  <td scope="row">
                      @if (isset($timetable_days[$key]))
                          @foreach ($timetable_days[$key] as $timetable_day)
                              <div class="py-2" style="border-bottom: 1px solid rgba(0,0,0,0.12)">
                                <div>
                                  {{ (new DateTime($timetable_day->start_time))->format('H:i') }}
                                  - {{ (new DateTime($timetable_day->end_time))->format('H:i') }}
                                </div>
                                <div>{{ $timetable_day->subject->label }}</div>
                                <div>({{ $timetable_day->user->firstname }} {{ $timetable_day->user->lastname }})</div>
                              </div>
                          @endforeach
                      @endif
                  </td>
              @endforeach
            </tr>
          </tbody>
        </table>
        @if (!$is_student)
          <div class="text-center mt-5">
            <h6><span class="text-decoration-underline">NB:</span> Auncune modification ne saurait intervenir sans l'avis du Censeur.</h6>
          </div>
        @endif
        
      </div>
    @else
      <h6 class="text-center mute">Aucun emploi disponible pour le moment pour cette classe.</h6>
    @endif
    
  </div>
 </div>
  
 @endsection