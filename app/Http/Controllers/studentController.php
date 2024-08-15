<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Timetable;
use App\Models\TimetableByDay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Request;

class StudentController extends Controller
{


    public function index()
    {
        $students = User::query();
        $students->where('role_id', '=', Role::STUDENT);
        return view('admin.student', ['students' => $students->get()]);
    }

    public function dashboard(Timetable $timetable, TimetableByDay $days) {

        $user = Auth::user();

        $search = $timetable->where(['level_id' => $user->level_id])->get()->first();
        $daysString = TimetableByDay::$days;

        if ($search) {

            $timetable_days = $days->where(['timetable_id' => $search->id])->get();

            $totalHours = $timetable_days->reduce(function ($carry, $class) {
                $startTime = Carbon::parse($class->start_time);
                $endTime = Carbon::parse($class->end_time);
                return $carry + $endTime->diffInHours($startTime);
            }, 0);
            
            // Calculer le nombre total de cours par semaine
            $totalClasses = $timetable_days->count();
            
            // Calculer le nombre d'heures par jour
            $dayHours = $timetable_days->groupBy('day')->map(function ($dayClasses) {
                return $dayClasses->reduce(function ($carry, $class) {
                    $startTime = Carbon::parse($class->start_time);
                    $endTime = Carbon::parse($class->end_time);
                    return $carry + $endTime->diffInHours($startTime);
                }, 0);
            });
            
            // Déterminer la journée la plus et la moins chargée
            $mostBusyDay = $dayHours->sortDesc()->keys()->first();
            $leastBusyDay = $dayHours->sort()->keys()->first();

            return view('student.dashboard',[
                'totalHours' => $totalHours,
                'totalClasses' => $totalClasses,
                'mostBusyDay' => $daysString[$mostBusyDay],
                'leastBusyDay' => $daysString[$leastBusyDay]
            ]);
        }

        return view('student.dashboard',[
            'totalHours' => '-',
            'totalClasses' => '-',
            'mostBusyDay' => '-',
            'leastBusyDay' => '-'
        ]);
    }

    public function show(Request $request, Timetable $timetable, TimetableByDay $days)
    {

        $timetable = $timetable->where('level_id', '=', Auth::user()->level_id)->get()->first();

        $timetable_days_grouped = [];

        if ($timetable) {
            $timetable_days = $days->where('timetable_id', '=', $timetable->id)->get();

            foreach ($timetable_days as $timetable_day) {
                $timetable_days_grouped[$timetable_day->day][] = $timetable_day;
            }
        }


        return view('admin.timetableshow', [
            'timetable' => $timetable,
            'timetable_days' => $timetable_days_grouped,
            'days' => TimetableByDay::$days,
            'is_student' => true
        ]);
    }
    public function blocked(User $student)
    {
        if ($student->isblocked()) {
            $student->blocked = false;
            $student->save();
            toastr()->success("L'élève est débloqué avec succès");
        } else {
            $student->blocked = true;
            $student->save();
            toastr()->success("L'élève est bloqué avec succès");
        }

        return redirect()->route('student.index');
    }

    public function destroy(User $student)
    {
        $student->delete();
        toastr()->success("L'éleve à été supprimé avec succès !");
        return redirect()->route('student.index');
    }
}
