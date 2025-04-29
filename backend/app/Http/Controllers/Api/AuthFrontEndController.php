<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UsersInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class AuthFrontEndController extends Controller
{
    public function register(Request $request)
    {
        // Validazione dei dati
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crea l'utente
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user_info = UsersInfo::create([
            'name' => $request->user_name,
            'lastname'=> $request->user_lastname,
            'birthday' => $request->birthday,
            'profile_img' => $request->profile_img,
            'user_id'=> $user->id,
        ]);

        // $token = $user->createToken('UserRegistrationToken')->plainTextToken;

        // Risposta di successo
        return response()->json([
            'success' => true,
            'message' => 'Registrazione riuscita!',
            'user' => $user,
            'user_info' => $user_info,
            // 'token' => $token, // Ritorna il token per la sessione dell'utente
        ]);
    }
       public function login(Request $request){

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $request->session()->regenerate();
        return response()->json(['message' => 'Login successful']);
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message'=> 'Logged out']);
    }
}
