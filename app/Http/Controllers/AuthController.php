<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'token' => $token,
                'user_id' => $user->id
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid ids',
            ], 401);
        }
    }

    // LOGOUT method
    // public function logout(Request $request)
    // {
    //     $request->user()->tokens()->delete();
    //     return response()->json(['message' => 'Logging out.']);
    // }
}
