<?php

namespace App\Http\Controllers\GoogleModule;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

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

            $existing_employee = User::where('google_id', $google_obj->user['id'])->first();

            if ($existing_employee) {
                Auth::login($existing_employee, true);
                return redirect()->route('employee.meeting.index');
            } else {

                //new user
                $new_employee = User::where('email', $google_obj->user['email'])->first();

                // if ($employee) {
                //     //email exists, update google_id in database
                //     User::where('email', $google_obj->user['email'])->update(['google_id' => $google_obj->user['id']]);
                //     return redirect()->route('employee.emp.create');

                // } else {
                //     //email does not exist
                //     return redirect('/');
                // }

                $new_employee = User::create([
                    'name' => $google_obj->user['name'],
                    'email' => $google_obj->user['email'],
                    'google_id' => $google_obj->user['id'],
                    'role_id' => User::ROLES['EMPLOYEE'],
                ]);

                Auth::login($new_employee, true);
                return redirect()->route('employee.meeting.index');

            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
