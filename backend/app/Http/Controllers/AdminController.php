<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use App\Models\UsersInfo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboardStats(Request $request)
    {
        $user = Auth::user()->load('info');
        $userRole = $user->user_role;

        $roleColorClass = $userRole === 'admin' ? 'text-timenge-400' : 'text-blue-400';

        $messages = [
            'mattina' => ['Buongiorno', 'Buona giornata', 'Splendido inizio di giornata', 'Che bella mattinata', 'Inizia la giornata con il sorriso', 'Una mattina piena di energia', 'Svegliati e risplendi'],
            'pomeriggio' => ['Buon pomeriggio', 'Splendido pomeriggio', 'Una pausa rigenerante', 'Continua cosi, sei sulla buona strada', 'Goditi il pomeriggio', 'Pomeriggio produttivo', 'Che bel pomeriggio'],
            'sera' => ['Buonasera', 'Buona serata', 'Tramonto rilassante', 'Serata rilassante a te', 'Fine giornata con il sorriso', 'Spero tu stia passando una bella serata', 'Tempo di relax', 'Che la tua serata sia serena'],
            'notte' => ['Buonanotte', "Sogni d'oro", 'Riposa bene', 'Notte tranquilla a te'],
        ];
        $emojis = [
            'mattina' => ['☀️', '🌻', '🌅', '🥐', '☕'],
            'pomeriggio' => ['🌞', '🍵', '📚'],
            'sera' => ['🌙', '✨', '🌟', '🛋️', '🍷'],
            'notte' => ['🌙', '🌌', '🛏️', '💤', '✨']
        ];
        date_default_timezone_set('Europe/Rome');

        $time = now()->format('H');
        if ($time >= 6 && $time < 12)
            $slot = 'mattina';
        elseif ($time >= 12 && $time < 18)
            $slot = 'pomeriggio';
        elseif ($time >= 17 && $time < 24)
            $slot = 'sera';
        else
            $slot = 'notte';

        $messageText = $messages[$slot][array_rand($messages[$slot])];
        $messageEmoji = null;

        if (rand(0, 1)) {
            $messageEmoji = $emojis[$slot][array_rand($emojis[$slot])];
        }

        if (rand(0, 1)) {
            $messageText .= ', ' . $user->info->firstname;
        }

        return view('admin.dashboard', compact(
            'user',
            'userRole',
            'messageText',
            'messageEmoji',
        ));
    }
}
