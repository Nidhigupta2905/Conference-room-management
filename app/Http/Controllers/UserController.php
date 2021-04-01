<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

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
            $user = User::where('google_id', $google_user->getId())->first();

            // dd($user);
            if(!$user){
                $user = User::create([
                    'email'=>$google_user->getEmail(),
                    'name'=>$google_user->getName(),
                    'google_id'=>$google_user->getId(),
                    'password'=>Hash::make('password')
                ]);
            }
            Auth::login($user, true);
            return redirect()->route('booking.home');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
