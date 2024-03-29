<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    // Show wallet balance
    public function show()
    {
        return view('user_template.wallet');
    }

    // Show top-up form
    public function showTopupForm()
    {
        return view('user_template.topup');
    }

    // Process top-up action
    public function topup(Request $request)
    {
        $user = auth()->user();
        $amount = $request->input('amount');

        // Validate top-up amount
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Update the user's wallet balance in the database
        $user->update(['wallet_balance' => $user->wallet_balance + $amount]);

        return redirect()->route('wallet')->with('success', 'Balance topped up successfully!');
    }
}
