<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(User::rules());

        User::create(array_merge(
            $request->all(),
            [
                'is_active' => false,
                'role' => 'user'
            ]
        ));

        return response()->json([
            'success' => true,
            'data' => null
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if (!$token)
            return response()->json(['error' => 'Unauthorized'], 401);

        return $this->respondWithToken($token, auth()->user());
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'data' => null
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), null);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'success' => true,
            'token' => $token,
            'data' => $user,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
