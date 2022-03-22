<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('EMAIL', $request->email)
                    ->get()
                    ->first(function ($u, $key) use ($request) {
                        return ($u->activePassword() == $request->password);
                    });

        $users = User::where('EMAIL', $request->email)
            ->get();

        $userOld = $users->first(function ($u, $key) use ($request) {
                return ($u->activePassword() == $request->password);
            });

        if ($userOld) {
            auth()->login($userOld);
        } else {
            $attempt = false;
            foreach ($users as $key => $user) {
                $attempt = auth()->attempt([
                    'email' => $user->EMAIL,
                    'password' => $request->password,
                ]);

                if ($attempt) {
                    break;
                }
            }
        }

        if (auth()->guard()->check()) {
            session(['authId' => auth()->guard()->user()->ID]);
            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        session()->forget('authId');

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
