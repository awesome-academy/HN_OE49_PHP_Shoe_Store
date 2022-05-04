<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);
            $user = $this->userRepo->findByWhere(['email' => $request->email])->first();

            if (!Auth::attempt($credentials) || !Hash::check($request->password, $user->password, [])) {
                return response()->json([
                    'status_code' => 500,
                    'message' => __('login-fail'),
                ]);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status_code' => 500,
                'error' => $exception,
            ]);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => __('logout'),
        ], 200);
    }
}
