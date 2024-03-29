<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Auth\AuthController;




class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            // Get the user's phone number
            $phoneNumber = $user->phone_number;
            $request->session()->put('phone_number', $user->phone_number);

            // Send verification code via Twilio
            $this->sendVerificationCode($phoneNumber);

            return redirect()->route('verifyotp');
        }

        //return redirect()->intended(RouteServiceProvider::HOME);
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Retrieve the authenticated user
        $user = Auth::user();

    // If the user is found, update isVerified to false
        if ($user) {
            $user->update(['isVerified' => false]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Send verification code to the provided phone number via Twilio.
     */
    private function sendVerificationCode($phoneNumber)
    {
        // Get Twilio credentials from .env file
        $token = config('services.twilio.auth_token');
        $twilio_sid = config('services.twilio.sid');
        $twilio_verify_sid = config('services.twilio.verify_sid');

        //because my twilio only can send to my owned phone number
        //Usually, by removing this line of code, it can be sent to the registered user's own phone number.
        $phoneNumber = "+60187663119";

        // Initialize Twilio Client
        $twilio = new Client($twilio_sid, $token);

        // Send verification code to the provided phone number via SMS
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($phoneNumber, "sms");
    }

    protected function verify(Request $request)
{
    $data = $request->validate([
        'verification_code' => ['required', 'numeric'],
        'phone_number' => ['required', 'string'],
    ]);

    // Get Twilio credentials from .env
    $token = config('services.twilio.auth_token');
    $twilio_sid = config('services.twilio.sid');
    $twilio_verify_sid = config('services.twilio.verify_sid');

    $twilio = new Client($twilio_sid, $token);

    try {
        // Verify the provided OTP
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create([
                'to' => $data['phone_number'],
                'code' => $data['verification_code']
            ]);

        // If verification is valid, log in the user
        if ($verification->valid) {
            $user = User::where('phone_number', $data['phone_number'])->first();

            // If user is found, log them in
            if ($user) {
                //update isVerified
                $user->update(['isVerified' => true]);
                Auth::login($user);
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                //return redirect::route('login')->withInput()->withErrors(['phone_number' => 'User not found']);
                
            }
        } else {
            return back()->withInput()->withErrors(['verification_code' => 'Invalid verification code entered!']);
        }
    } catch (\Exception $e) {
        // Handle any exceptions that occur during OTP verification
        return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
    }
}

    
}
