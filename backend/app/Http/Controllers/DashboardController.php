<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if ($user->user_role === 'admin') {
            return view('admin.dashboard', compact('user'));
        }

        if ($user->user_role === 'partner') {
            return view('partner.dashboard', compact('user'));
        }

        abort(403, 'Accesso non autorizzato');
    }
}
