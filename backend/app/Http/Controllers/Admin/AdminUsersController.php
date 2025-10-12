<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'email', 'user_role', 'created_at')->withCount([
            'eventRegistrations as total_registrations' => fn($q) => $q->where('status', 'registered'),
            'eventRegistrations as attended_count' => fn($q) => $q->where('status', 'attended'),
        ])

            ->where('user_role', 'user')
            ->get(['id', 'email', 'user_role', 'created_at']);

        $partners = User::select('partnerInfo.name', 'partnerInfo.lastname', 'contact_phone')->where('user_role', 'partner')
            ->select('id', 'email', 'user_role', 'created_at')
            ->get();

        return view("admin.users.index", compact("users", "partners"));
    }

    public function show(User $user)
    {
        if ($user->user_role === 'user') {
            $userData = User::with(['info', 'eventRegistrations.event'])
                ->findOrFail($user->id);
        } elseif ($user->user_role === 'partner') {
            $userData = User::with('partnerInfo')
                ->findOrFail($user->id);
        } else {
            abort(404, 'Ruolo utente non riconosciuto');
        }

        return view("admin.users.show", compact("userData"));
    }


    public function updateUserRole(User $user, Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:user,admin,librarian,partner'
        ]);

        $user->update(['user_role' => $validated['role']]);

        // Redirect alla pagina di dettaglio aggiornata
        return redirect()
            ->route('admin.users.show', $user->id)
            ->with('success', 'Ruolo aggiornato con successo.');
    }

}
