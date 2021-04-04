<?php

namespace App\Http\Controllers\GoogleModule;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $google_obj = Socialite::driver('google')->stateless()->user();
        
            $employee = User::where('google_id', $google_obj->user['id'])->first();

            if (!$employee) {
                $employee = User::create([
                    'email' => $google_obj->user['email'],
                    'name' => $google_obj->user['name'],
                    'google_id' => $google_obj->user['id'],
                    'role_id' => User::ROLES['EMPLOYEE']
                ]);
            }
            Auth::login($employee, true);
            return redirect()->route('employee.home');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
