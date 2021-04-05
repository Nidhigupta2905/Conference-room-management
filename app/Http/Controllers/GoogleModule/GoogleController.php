<?php

namespace App\Http\Controllers\GoogleModule;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;

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

            if ($employee) {
                Auth::login($employee, true);
                return redirect()->route('employee.home');
            } else {

                //new user
                $employee = User::where('email', $google_obj->user['email'])->first();

                if ($employee) {
                    //email exists, update google_id in database
                    User::where('email', $google_obj->user['email'])->update(['google_id'=>$google_obj->user['id']]);
                    return redirect()->route('employee.home');

                }else{
                    //email does not exist
                    return redirect('/');
                }

            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
