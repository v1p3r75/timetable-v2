<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreatedEmail;
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

        $fullname = $user->firstname . " " . $user->lastname;

        return $this->send_mail(new AccountCreatedEmail($fullname, $code, $user->role->label), $user->email);
    }

    protected function send_mail(Mailable $mail, $email) {

        return Mail::to($email)->send($mail);
    }
    
}
