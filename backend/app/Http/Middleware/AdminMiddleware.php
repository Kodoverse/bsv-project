<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login'); // se non loggato
        }

        // Controllo ruolo admin
        if (strtolower(trim($user->user_role)) !== 'admin') {
            abort(403, 'Accesso non autorizzato'); // invece di json
        }

        return $next($request);
    }
}
