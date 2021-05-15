<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;

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

    /**
     *
     * Admin Login
     */
    public function login(Request $request)
    {

        //TODO: add validation

        Validator::make($request->all(), [
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(ithands)\.com|\.biz$/i',
            ],
        ])->validate();
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 1,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            return redirect()->route('admin.home');
        }
        return redirect()->back()->withErrors(["email" => "These credentials do not match our records."]);
    }
}
