<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request['password']),
            'picture' => env('AVATAR_GENERATOR_URL') . $request['name']
        ]);

        $token = auth()->login($users);

        if (!$token) {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Gagal Melakakukan SignUp'
                ],
                'data' => []
            ]);
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Berhasil Melakakukan SignUp'
            ],
            'data' => [
                'users' => [
                    'name' => $users->name,
                    'email' => $users->email,
                    'picture' => $users->picture
                ],
                'access_token' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL() . 'minutes')
                ]
            ],
        ]);
    }
}
