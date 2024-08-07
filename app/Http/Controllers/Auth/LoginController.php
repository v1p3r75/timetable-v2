<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Http\Request;
use Route;

class LoginController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }
    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        $remenber = $request->has('remenber');

        if (Auth::attempt($credentials, $remenber)) {

            session()->regenerate();
            if (Auth::user()->isblocked()) {

                Auth::logout();
                return redirect()->route('auth.login')->withErrors(
                    ['email' =>  "Les identifiants sont incorrectes"]
                )->onlyInput('email');;

            } else {

                $user = Auth::user();
                
                if (in_array($user->role_id, [Role::CENSOR, Role::DEPUTY_CENSOR])) {

                    return redirect()->intended(RouteServiceProvider::HOME);

                } else if ($user->role_id === Role::TEACHER) {
                    
                    return redirect()->intended(RouteServiceProvider::STUDENT);
                } else {
                    
                    return redirect()->intended(RouteServiceProvider::STUDENT);
                }
            }
        }
        return  back()->withErrors(
            ['email' =>  "Les identifiants sont incorrectes"]
        )->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
