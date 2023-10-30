<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $validated = $request->validated();
        $users = User::create([
            'name' => $validated->name,
            'email' => $validated->email,
            'password' => bcrypt($validated['password']),
            'picture' => env('AVATAR_GENERATOR_URL') . $validated['name']
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
                    'type' => 'Bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL() . 'minutes')
                ]
            ],
        ], 200);
    }


    public function signIn(SignInRequest $request){
        $token = auth()->attempt($request->validated());

        if (!$token) {
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'errors',
                    'message' => 'Password Atau Username Salah'
                ],
                'data' => []
            ], 401);
        }

        $users = auth()->user();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'succes',
                'message' => 'Berhasil login'
            ],
            'data' => [
                'name' => $users->name,
                'email' => $users->email,
                'picture' => $users->picture
            ],
            'access_token' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => strtotime('+' . auth()->factory()->getTTL() . ' minutes')
            ],
        ], 200);

    }
}
