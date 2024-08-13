<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreatedEmail;
use App\Mail\TimetableCreatedTeacherEmail;
use App\Models\Role;
use App\Models\Timetable;
use App\Models\TimetableByDay;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Mail\Mailable;
use Illuminate\Routing\Controller as BaseController;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected function send_account_created_email(User $user, string $code) {


        return $this->send_mail(
            new AccountCreatedEmail($this->getFullName($user), $code, $user->role->label),
            $user->email
        );
    }

    protected function send_timetable_email(Timetable $timetable) {

        $result = TimetableByDay::where('timetable_id', $timetable->id)->groupBy('user_id')->get();

        $users = $result->map(fn($t) => $t->user->email);
        
        // dd($users);

        // return $result->map(function ($t) {
        //     $this->send_mail(
        //         new TimetableCreatedTeacherEmail(
        //             $this->getFullName($t->user),
        //             $this->
        //         ),
        //         $users
        //     );
        // });
    }

    protected function getFullName(User $user): string {

        return  $user->firstname . " " . $user->lastname;
    }

    protected function send_mail(Mailable $mail, $email) {

        return Mail::to($email)->send($mail);
    }
    
}
