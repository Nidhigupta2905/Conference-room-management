<?php

namespace App\Http\Controllers\GoogleModule;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;


class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {

            $google_obj = Socialite::driver('google')->stateless()->user();

            $existing_employee = User::where('google_id', $google_obj->user['id'])->first();

            if ($existing_employee) {
                Auth::login($existing_employee, true);
                return redirect()->route('employee.meeting.index');
            } else {

                //new user
                $match_email = preg_match('/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(ithands)\.com|\.biz$/i', $google_obj->user['email']);

                if ($match_email) {

                    $new_employee = User::create([
                        'name' => $google_obj->user['name'],
                        'email' => $google_obj->user['email'],
                        'google_id' => $google_obj->user['id'],
                        'image' => $google_obj->user['picture'],
                        'role_id' => User::ROLES['EMPLOYEE'],
                    ]);

                    Auth::login($new_employee, true);
                    return redirect()->route('employee.meeting.index');
                } else {
                    $request->session()->flash("error", "Mail should be @ithands.com | @ithands.biz");
                    return redirect()->back();

                }

            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
