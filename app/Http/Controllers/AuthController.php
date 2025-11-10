<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => ['These credentials do not match our records.']
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('ApiToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ], 200);
    }


    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'success' => false,
                'message' => ['Email is already registered, please use another email'],
            ], 409);
        }

        $register = new User();
        $register->name = $request->name;
        $register->email = $request->email;
        $register->email_verified_at = now();
        $register->password = Hash::make($request->password);
        $register->remember_token = Str::random(10);
        $register->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully Register Account!',
            'user' => $register,
        ], 201);
    }
}
