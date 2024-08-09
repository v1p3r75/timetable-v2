<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Models\Role;
use App\Models\Timetable;
use App\Models\TimetableByDay;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::query();
        $teachers->where('role_id', '=', Role::TEACHER);
        return view('admin.teacher', ['teachers' =>   $teachers->get()]);
    }
    public function create()
    {
        return view('admin.form.teacher', ['teacher' => new User()]);
    }

    public function dashboard(Timetable $timetable, TimetableByDay $days)
    {

        $user = Auth::user();
        $timetable_days = $days->where(['user_id' => $user->id])->get();

        $daysString = TimetableByDay::$days;

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

        return view('student.dashboard', [
            'totalHours' => $totalHours,
            'totalClasses' => $totalClasses,
            'mostBusyDay' => $daysString[$mostBusyDay],
            'leastBusyDay' => $daysString[$leastBusyDay]
        ]);
    }

    public function timetables(Timetable $timetable, TimetableByDay $days)
    {

        $user = Auth::user();
        $timetables = $days->where(['user_id' => $user->id])->groupBy('timetable_id')->get()->map(fn ($t) => $t->timetable_id);

        $all = $timetables->map(fn ($id) => $timetable->where(['id' => $id])->get()->first());

        return view('admin.timetable', ['timetables' => $all, 'is_teacher' => true]);
    }

    public function show(Timetable $timetable, TimetableByDay $days)
    {

        $timetable_days = $days->where('timetable_id', '=', $timetable->id)->get();
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
            'is_student' => false
        ]);
    }


    public function store(TeacherRequest $request)
    {
        $teacher = new User();
        $teacher = $teacher->create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'serial_number' => $request->serial_number,
            'role_id' => Role::TEACHER,
            'password' => Hash::make(Str::random(8)),
        ]);

        /* envoyer un mail au proffesseur pour quil met a jour son compte */
        toastr()->success("Le proffesseur à été créer avec succès !");
        return redirect()->route('teacher.index');
    }
    public function edit(User $teacher)
    {
        return view('admin.form.teacher', ['teacher' => $teacher]);
    }

    public function update(User $teacher, TeacherUpdateRequest $request)
    {

        $teacher = $teacher->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'serial_number' => $request->serial_number,
            'role_id' => Role::TEACHER,

        ]);
        toastr()->success("Le proffesseur à été mise à jour avec succès !");
        return redirect()->route('teacher.index');
    }
    public function destroy(User $teacher)
    {
        $teacher = $teacher->delete();
        toastr()->success("Le proffesseur à été supprimer avec succès  !");
        return redirect()->route('teacher.index');
    }
}
