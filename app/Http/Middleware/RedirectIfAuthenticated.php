<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if (Auth::user()->role_id == User::ROLES['ADMIN']) {
                    return redirect()->route('admin.home');
                } else if (Auth::user()->role_id == User::ROLES['EMPLOYEE']) {
                    return redirect()->route('employee.dashboard');
                } else {
                    Auth::logout();
                    return redirect()->back()->withErrors(["email" => "These credentials do not match our record"]);
                }
            }
        }

        return $next($request);
    }
}
