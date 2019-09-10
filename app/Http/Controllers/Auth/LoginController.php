<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Http\Controllers\Auth\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Response;
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
    protected $maxAttempts = 3;
    protected $decayMinutes = 1; // Default is 1
    private $count=0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    protected function credentials(Request $request)
    {
        if (is_numeric($request->get($this->username()))) {
            return ['phone' => $request->get($this->username()), 'password' => $request->get('password')];
        } elseif (filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get($this->username()), 'password' => $request->get('password')];
        }
    }

    // protected function sendFailedLoginResponse(Request $request)
    // {
        // if ($this->maxAttempts > 3) {
        //     throw ValidationException::withMessages([
        //         $this->username() => [trans('auth.failed')],
        //     ])->redirectTo("/re-login");
        // } else {
        //     throw ValidationException::withMessages([
        //         $this->username() => [trans('auth.failed')],
        //     ]);
        // }
       
    // }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS)->redirectTo("/re-login");
    }


}
