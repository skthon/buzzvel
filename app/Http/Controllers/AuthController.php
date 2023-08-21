<?php

namespace  App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends  Controller
{
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status'       => 200,
            'access_token' => $token,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'code'    => 401,
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'code'         => 200,
            'access_token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'code'    => 200,
            'message' => 'Logged out successfully',
        ]);
    }
}
