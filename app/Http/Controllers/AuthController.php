<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;


class AuthController extends Controller
{
//     protected function verify(Request $request)
// {
//     $data = $request->validate([
//         'verification_code' => ['required', 'numeric'],
//         'phone_number' => ['required', 'string'],
//     ]);
    
//     /* Get credentials from .env */
//     $token = config('services.twilio.auth_token');
//     $twilio_sid = config('services.twilio.sid');
//     $twilio_verify_sid = config('services.twilio.verify_sid');
    
//     $twilio = new Client($twilio_sid, $token);
//     $verification = $twilio->verify->v2->services($twilio_verify_sid)
//         ->verificationChecks
//         ->create([
//             'to' => $data['phone_number'],
//             'code' => $data['verification_code']
//         ]);

//     if ($verification->valid) {
//         // Find the user by phone number
//         $user = User::where('phone_number', $data['phone_number'])->first();
        
//         // If user is found and verified, log them in
//         if ($user && $user->isVerified) {
//             Auth::login($user);
//             return redirect()->intended(RouteServiceProvider::HOME);
//         }
//     }
    
//     return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
// }
}
