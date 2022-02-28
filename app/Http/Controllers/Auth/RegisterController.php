<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    protected function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'regex:/(0[3|5|7|8|9])+([0-9]{8})\b/', 'unique:users'],
            'address' => ['required', 'max:1000'],
        ], [
            'name.required' => __('required', ['attr' => __('name')]),
            'name.string' => __('string', ['attr' => __('name')]),
            'name.min' => __('min', ['attr' => __('name'), 'value' => '6']),
            'name.max' => __('max', ['attr' => __('name'), 'value' => '255']),
            'email.required' => __('required', ['attr' => __('email')]),
            'email.email' => __('email_val'),
            'email.max' => __('max', ['attr' => __('email'), 'value' => '255']),
            'email.unique' => __('unique', ['attr' => __('email')]),
            'password.required' => __('required', ['attr' => __('password')]),
            'password.string' => __('string', ['attr' => __('password')]),
            'password.min' => __('min', ['attr' => __('password'), 'value' => '8']),
            'password.confirmed' => __('confirmed', ['attr' => __('password')]),
            'phone.required' => __('required', ['attr' => __('phone')]),
            'phone.regex' => __('regex', ['attr' => __('phone')]),
            'phone.unique' => __('unique', ['attr' => __('phone')]),
            'address.required' => __('required', ['attr' => __('address')]),
            'address.max' => __('max', ['attr' => __('address'), 'value' => '1000']),
        ]);

        $result = User::insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'role_id' => config('auth.roles.user'),
        ]);

        if (!$result) {
            return redirect()
                ->back()
                ->with('message', __('regisF'));
        }

        return redirect()
            ->route('login')
            ->with('message', __('regisS'));
    }
}
