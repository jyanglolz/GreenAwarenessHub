<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user is verified
            if (!Auth::user()->isVerified) {
                // Redirect to OTP verification page or any other action
                return redirect()->route('verifyotp');
            }
        } else {
            // Redirect to login page if the user is not authenticated
            return redirect()->route('login');
        }

        return $next($request);
    }
}
