<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show()
    {
        return view('user_template.wallet');
    }

    public function topup(Request $request)
    {
        // Handle top-up logic here
    }
}
