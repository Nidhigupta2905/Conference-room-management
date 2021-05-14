<?php

namespace App\Http\Controllers\GoogleModule;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use App\Http\Requests\googleEmail\GoogleEmailValidation;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        //TODO: email domain name check validation
        try {

            $google_obj = Socialite::driver('google')->stateless()->user();

            $existing_employee = User::where('google_id', $google_obj->user['id'])->first();

            if ($existing_employee) {
                Auth::login($existing_employee, true);
                return redirect()->route('employee.meeting.index');
            } else {

                //new user
                $new_employee = User::where('email', $google_obj->user['email'])->first();
                $new_employee = User::create([
                    'name' => $google_obj->user['name'],
                    'email' => $google_obj->user['email'],
                    'google_id' => $google_obj->user['id'],
                    'image' => $google_obj->user['picture'],
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
