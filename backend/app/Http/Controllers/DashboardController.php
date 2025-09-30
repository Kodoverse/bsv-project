<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if ($user->user_role === 'admin') {
            // invece di redirect, chiama direttamente il metodo del controller admin
            return app()->call([AdminController::class, 'dashboardStats']);
        }

        if ($user->user_role === 'partner') {
            return app()->call([PartnerController::class, 'index']);
        }
        abort(403, 'Accesso non autorizzato');
    }
}
