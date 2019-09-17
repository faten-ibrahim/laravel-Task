<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Http\Controllers\Auth\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
    protected $decayMinutes = 0.1; // Default is 1
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
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);
    }

    protected function credentials(Request $request)
    {
        $credentials_arr = [];
        $credentials_arr = ['password' => $request->get('password')];
        if (is_numeric($request->get('email'))) {
            $credentials_arr += ['phone' => $request->get('email')];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials_arr += ['email' => $request->get('email')];
        }

        return $credentials_arr;
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        
        $value = $this->limiter()->attempts($this->throttleKey($request));
        // dd($value);
        Log::info(session('attempts'));
        if ($value >= $this->maxAttempts) {
            session(['attempts' => $value]);
        }
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],

        ]);
    }

}
