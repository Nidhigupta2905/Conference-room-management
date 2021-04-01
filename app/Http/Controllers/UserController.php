<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $user->getId())->first();

            dd($user);
            if(!$user){
                $user = User::create([
                    'email'=>$google_user->getEmail(),
                    'name'=>$google_user->getName(),
                    'google_id'=>$google_user->getId()
                ]);
            }
            Auth::login($user, true);
            return redirect('welcome');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
