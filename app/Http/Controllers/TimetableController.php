<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimestableRequest;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User;
use DateTime;
use DB;
use Exception;
use Illuminate\Http\Request;
use Validator;

class TimetableController extends Controller
{
    private array $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.timetable', ['timetables' => Timetable::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::query();
        $teachers->where('role_id', '=', Role::TEACHER);
        $classrooms = Classroom::all();

        return view('admin.form.timetable', [
            'timetable' => new Timetable(),
            'teachers' => $teachers->get(),
            'classrooms' => $classrooms,
            'levels' => Level::all(),
            'subjects' => Subject::all(),
            'days' => $this->days
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Timetable $timetable)
    {
        $rules = [
            'teacher' => ['required', 'array'],
            'subject' => ['required',],
            'start_time' => ['required', 'array'],
            'end_time' => ['required', 'array'],
            'level' => ['required', 'numeric'],
            'classroom' => ['required', 'numeric']
        ];

        if ($result = validator($request->all(), $rules)->fails()) {

            return response()->json(['success' => false, 'message' => "Vérifier si les champs sont tous remplis"]);

        }

        DB::beginTransaction();

        $timetable->classroom_id = $request->classroom;
        $timetable->level_id = $request->level;
        $timetable->save();

        foreach ($request->day as $key => $day) {

            if (!isset($request->teacher[$key], $request->subject[$key], $request->start_time[$key], $request->end_time[$key])) {

                return response()->json(['success' => false, 'message' => "Vérfier si tous les champs sont remplis pour " . $this->days[$day]]);
  
            }

            try {

                $start_time = new DateTime($request->start_time[$key]);
                $end_time = new DateTime($request->end_time[$key]);

                if ($start_time > $end_time) {

                    return response()->json([
                        'success' => false,
                        'message' => sprintf("%s : La date de fin (%s) ne pas être inférieur à la date de début (%s)", $this->days[$day], $request->end_time[$key], $request->start_time[$key])
                    ]);
                }
                $days = DB::table('timetable_days');
                
                // if ($days->where(['day' => $key]))

                $days->insert([
                    'day' => $key,
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

        return response()->json(['success' => true, 'message' => "Emploi du temps crée avec succés"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        return view('admin.timetableshow', compact('timetable'));
    }

    public function edit(Timetable $timetable)
    {
        $teachers = User::query();
        $teachers->where('role_id', '=', 2);
        $classrooms = Classroom::query();
        $classrooms->where('status', '=', 'on');
        return view('admin.form.timetable', ['timetable' => $timetable, 'teachers' => $teachers->get(), 'classrooms' => $classrooms->get(), 'levels' => Level::all(), 'subjects' => Subject::all()]);
    }
    public function update(Timetable $timetable, TimestableRequest $request)
    {
        $startformat = new DateTime($request->start_time);
        $endformat = new DateTime($request->end_time);

        $start = $startformat->format('Y-m-d H:i');
        $end = $endformat->format('Y-m-d H:i');

        $week = $startformat->format('W');

        if ($start < $end) {
            $timetable->update([
                'week' => $week,
                'user' => $request->teacher,
                'subject' => $request->subject,
                'classroom' => $request->classroom,
                'level' => $request->level,
                'start_time' => $start,
                'end_time' => $end,
            ]);
            toastr()->success("L'emploi du temps à été mise à jour avec succès !");
        } else {
            toastr()->error("L'heure de debut ne doit pas être superieure à celle de fin ?!");
        }
        return redirect()->route('timetable.index');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable = $timetable->delete();
        toastr()->success("L'emploi du temps à été supprimer avec succès  !");
        return redirect()->route('timetable.index');
    }
}
