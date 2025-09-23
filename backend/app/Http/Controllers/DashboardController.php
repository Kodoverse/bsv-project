<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        $user = auth()->user();
        $role = strtolower(trim($user->user_role));

        // Controllo ruolo
        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role == 'partner') {
            return redirect()->route('partner.dashboard');
        }

        abort(403, 'Accesso non autorizzato');
    }
}
