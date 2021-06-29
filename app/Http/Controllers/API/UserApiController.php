<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserApiController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' =>['required', 'string', 'email', 'max:255', 'unique:users'],
                'phoneNumber' => ['nullable', 'string', 'max:255'],
                'password' =>['required', 'string', new Password],
            ]);
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phoneNumber' => $request->phoneNumber,
                'password' => Hash::make($request->password),
            ]);

            $user = User::wehere('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user 
            ], 'User Registered');
        }
        catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Authentification Failed', 500);
        }
    } 
}
