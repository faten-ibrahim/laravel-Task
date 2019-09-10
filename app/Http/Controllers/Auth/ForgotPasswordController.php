<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function validateEmail(Request $request)
    {
        //specify your custom message here
        $messages = [
            'required' => 'This field is required',
            'exists'    => 'The input you entered does not exist',
            'phone' => 'This phone is invalid'
        ];
        if (is_numeric($request->get('email'))) {
            $request->validate(['email' => 'required|exists:users,phone'], $messages);
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $request->validate(['email' => 'required|email'], $messages);
        }
    }
    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['phone' => $request->get('email')];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email')];
        }
        return $request->only('email');
    }
}
