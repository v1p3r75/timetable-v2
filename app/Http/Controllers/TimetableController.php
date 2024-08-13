<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimestableRequest;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\TimetableByDay;
use App\Models\User;
use Auth;
use DateTime;
use DB;
use Exception;
use Illuminate\Http\Request;
use Validator;

class TimetableController extends Controller
{

    private array $rules = [
        'teacher' => ['required', 'array'],
        'subject' => ['required',],
        'start_time' => ['required', 'array'],
        'end_time' => ['required', 'array'],
        'level' => ['required', 'numeric'],
        'classroom' => ['required', 'numeric']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.timetable', ['timetables' => Timetable::all(), 'is_teacher' => false]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::query();
        $teachers->where('role_id', '=', Role::TEACHER);
        $classrooms = Classroom::all();
        $levels = Level::all();

        $classrooms_not_programmed = $classrooms->filter(function ($classroom) {

            return is_null($classroom->timetable);
        });

        $levels_not_programmed = $levels->filter(function ($level) {

            return is_null($level->timetable);
        });

        return view('admin.form.timetable', [
            'timetable' => new Timetable(),
            'teachers' => $teachers->get(),
            'classrooms' => $classrooms_not_programmed,
            'levels' => $levels_not_programmed,
            'subjects' => Subject::all(),
            'days' => TimetableByDay::$days
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Timetable $timetable, TimetableByDay $days)
    {

        if (validator($request->all(), $this->rules)->fails()) {

            return response()->json(['success' => false, 'message' => "Vérifier si les champs sont tous remplis"]);
        }

        DB::beginTransaction();

        $timetable->classroom_id = $request->classroom;
        $timetable->level_id = $request->level;
        $timetable->save();

        $result = [];

        foreach ($request->day as $key => $day) {

            if (!isset($request->teacher[$key], $request->subject[$key], $request->start_time[$key], $request->end_time[$key])) {

                return response()->json(['success' => false, 'message' => "Vérfier si tous les champs sont remplis pour " . TimetableByDay::$days[$day]]);
            }

            try {

                $start_time = new DateTime($request->start_time[$key]);
                $end_time = new DateTime($request->end_time[$key]);

                if ($start_time > $end_time) {

                    return response()->json([
                        'success' => false,
                        'message' => sprintf("%s : La date de fin (%s) ne pas être inférieur à la date de début (%s)", TimetableByDay::$days[$day], $request->end_time[$key], $request->start_time[$key])
                    ]);
                }
                // if ($days->where(['day' => $key]))

                $result = $days->insert([
                    'day' => $day,
                    'timetable_id' => $timetable->id,
                    'user_id' => $request->teacher[$key],
                    'subject_id' => $request->subject[$key],
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                ]);
            } catch (Exception $e) {

                return response()->json(['success' => false, 'message' => "Une erreur s'est produite"]);
            }
        }

        DB::commit();

        // $this->send_timetable_email($timetable);

        return response()->json(['success' => true, 'message' => "Emploi du temps crée avec succés"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable, TimetableByDay $days)
    {

        $timetable_days = $days->where('timetable_id', '=', $timetable->id)->get();
        $timetable_days_grouped = [];

        foreach ($timetable_days as $timetable_day) {
            $timetable_days_grouped[$timetable_day->day][] = $timetable_day;
        }
        
        return view('admin.timetableshow', [
            'timetable' => $timetable,
            'timetable_days' => $timetable_days_grouped,
            'days' => TimetableByDay::$days,
            'is_student' => false
        ]);
    }

    public function edit(Timetable $timetable, User $user)
    {
        $teachers = User::where(['role_id' => Role::TEACHER]);

        return view('admin.form.timetable_update', [
            'timetable' => $timetable,
            'timetable_days' => TimetableByDay::where(['timetable_id' => $timetable->id])->get(),
            'teachers' => $teachers->get(),
            'classrooms' => Classroom::all(),
            'levels' => Level::all(),
            'subjects' => Subject::all(),
            'days' => TimetableByDay::$days
        ]);
    }
    public function update(Timetable $timetable, Request $request, TimetableByDay $days)
    {

        if (validator($request->all(), $this->rules)->fails()) {

            return response()->json(['success' => false, 'message' => "Vérifier si les champs sont tous remplis"]);
        }

        DB::beginTransaction();

        if (($timetable->level_id != $request->level) && Timetable::where(['level_id' => $request->level])->first()) {

            return response()->json([
                'success' => false,
                'message' => "La classe que vous avez sélectionné a déjà un emploi du temps"
            ]);
        }

        if (($timetable->classroom_id != $request->classroom) && Timetable::where(['classroom_id' => $request->classroom])->first()) {

            return response()->json([
                'success' => false,
                'message' => "La salle que vous avez sélectionné a déjà un emploi du temps"
            ]);
        }
        $timetable->update(['classroom_id' => $request->classroom, 'level_id' => $request->level]);


        foreach ($request->day as $key => $day) {

            if (!isset($request->teacher[$key], $request->subject[$key], $request->start_time[$key], $request->end_time[$key])) {

                return response()->json(['success' => false, 'message' => "Vérfier si tous les champs sont remplis pour " . TimetableByDay::$days[$day]]);
            }
        }

        foreach ($request->timetable_id as $key => $timetable_day) {

            try {

                $start_time = new DateTime($request->start_time[$key]);
                $end_time = new DateTime($request->end_time[$key]);

                if ($start_time > $end_time) {

                    return response()->json([
                        'success' => false,
                        'message' => sprintf("%s : La date de fin (%s) ne pas être inférieur à la date de début (%s)", TimetableByDay::$days[$day], $request->end_time[$key], $request->start_time[$key])
                    ]);
                }

                // insert a new timetable

                if ($timetable_day === 'null') {

                    $days->insert([
                        'day' => $request->day[$key],
                        'timetable_id' => $timetable->id,
                        'user_id' => $request->teacher[$key],
                        'subject_id' => $request->subject[$key],
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);
                } else { // update an existing timetable

                    $result = $days->where(['id' => $timetable_day])->first();

                    $result->update([
                        'user_id' => $request->teacher[$key],
                        'subject_id' => $request->subject[$key],
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);
                }
            } catch (Exception $e) {

                return response()->json(['success' => false, 'message' => "Une erreur s'est produite"]);
            }
        }

        // delete timetable

        foreach ($request->tasks_to_delete as $task) {

            if (isset($task)) {

                TimetableByDay::destroy($task);
            }
        }

        DB::commit();

        return response()->json(['success' => true, 'message' => "Emploi du temps modifié avec succés"]);
    }

    public function destroy(Timetable $timetable)
    {
        $timetable = $timetable->delete();
        toastr()->success("L'emploi du temps à été supprimer avec succès  !");
        return redirect()->route('timetable.index');
    }
}
