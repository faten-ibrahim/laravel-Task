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
use App\Rules\R_ecapcha;

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
    protected $redirectTo = '/';
    protected $maxAttempts = 3;
    protected $decayMinutes = 0.3; // Default is 1
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
            // 'g-recaptcha-response' => 'sometimes|recaptcha',
            'g-recaptcha-response' => [new R_ecapcha]
        ]);
    }

    protected function credentials(Request $request)
    {
        $credentials_arr = ['password' => $request->get('password')];
        if (is_numeric($request->get('email'))) {
            return array_merge($credentials_arr, ['phone' => $request->get('email')]);
        }

        return array_merge($credentials_arr, ['email' => $request->get('email')]);
    }


    protected function sendFailedLoginResponse(Request $request)
    {

        $value = $this->limiter()->attempts($this->throttleKey($request));
        // Log::info("hhhhhhhhhhhhhh");
        if ($value >= $this->maxAttempts) {
            session(['attempts' => $value]);
        }
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],

        ]);
    }

    protected function authenticated()
    {
        if (auth()->user()->type === 'admin') {
            return redirect('/home');
        }

        return redirect('/');
    }
}
