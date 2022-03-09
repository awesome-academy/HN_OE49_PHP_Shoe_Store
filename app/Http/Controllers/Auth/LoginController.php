<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if (Auth()->user()->role_id == config('auth.roles.admin')) {
            return route('admin');
        } else {
            return route('home');
        }
    }

    public function login(LoginRequest $request)
    {
        $compare = Auth()->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($compare) {
            if (Auth::user()->role_id == config('auth.roles.admin')) {
                return redirect()
                    ->route('admin')
                    ->with('noti', __('welcome'));
            } else {
                if (Auth::user()->status == config('auth.status.unlock')) {
                    return redirect()->route('home');
                } else {
                    Auth::logout();

                    return redirect()->route('login')->with('error', __('user lock'));
                }
            }
        } else {
            return redirect()->route('login')->with('error', __('login-fail'));
        }
    }
}
