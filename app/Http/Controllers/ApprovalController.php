<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{

    public function pending()
    {
        if (Auth::user()->is_approved) {
            return redirect()->route('dashboard');
        }

        return view('auth.pending-approval');
    }

}
