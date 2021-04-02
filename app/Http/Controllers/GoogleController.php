<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
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

            $google_user = Socialite::driver('google')->stateless()->user();
            $user = User::where('google_id', $google_user->getId())->first();

            // dd($google_user);
            if (!$user) {
                $user = User::create([
                    'email' => $google_user->getEmail(),
                    'name' => $google_user->getName(),
                    'google_id' => $google_user->getId(),
                ]);
            }
            Auth::login($user, true);
            return redirect()->route('booking.home');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
