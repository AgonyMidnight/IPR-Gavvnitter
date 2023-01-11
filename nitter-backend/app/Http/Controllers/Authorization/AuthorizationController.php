<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
        User::create([
            'name' => $request->user['name'],
            'login' => $request->user['login'],
            'email' => $request->user['email'],
            'avatar' => 'random/'.rand(1, config('app.count_random_avatar')).'.jpeg',
            'password' => Hash::make($request->user['password']),
        ]);

        return response()->json([], 200);
    }

    public function loginUser(LoginRequest $request)
    {
        if (!Auth::attempt($request->user)) {
            return response()->json([
                'message' => 'Incorrect login or password'
            ], 401);
        }
        $user = $request->user();

        $tokenResult = Auth::user()->createToken('Personal Access Token')->accessToken;
        $userData = [
            'id' => $user->id,
            'avatar' => $user->avatar,
            'name' => $user->name,
            'login' => $user->login,
            'email' => $user->email,
            'sex' => $user->gender,
        ];

        return response()->json([
            'userData' => $userData,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
        ], 200);

    }

    public function logout(Request $request)
    {
        $token = auth('api')->user()->token();
        $token->revoke();
        return response(['message' => 'You have successfully logout!'], 200);
    }

}
