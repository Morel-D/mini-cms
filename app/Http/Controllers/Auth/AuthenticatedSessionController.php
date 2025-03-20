<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

    if(!Auth::attempt($request->only('email', 'password'))){
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
        }

       $user = Auth::user();
       $token = $user->createToken('auth_token')->plainTextToken;


       return response()->json([
        'access_token'=> $token,
        'token_type'=> 'Bearer',
        'user' => $user,
        'status' => 'Login successful'
       ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful']);
    }
}
