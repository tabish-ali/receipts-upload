<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserSessionTimerController;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $maxAttempts = 5;
    protected $decayMinutes = 3;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'login'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        if (Auth::attempt($request->only($login_type, 'password'), true)) {
            // UserSessionTimerController::setSessionTimer();
            $user = Auth::user();
            $token = Auth::user()->api_token;
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return redirect()->back()
                ->withErrors([
                    'login' => 'Too many login attempts. Please wait 3 minutes before making another attempt.'
                ]);
        }

        if (Auth::attempt()) {
            $this->clearLoginAttempts($request);
        } else {
            $this->incrementLoginAttempts($request);
        }

        return redirect()->back()
            ->withInput()
            ->withErrors([
                'login' => 'These credentials do not match our records.'
            ]);
    }
}
