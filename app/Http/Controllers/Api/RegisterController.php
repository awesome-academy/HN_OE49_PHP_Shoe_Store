<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;
use Exception;

class RegisterController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterRequest $request)
    {
        try {
            if ($request->validator->fails()) {
                return response([
                    'error' => $request->validator->errors(),
                ], 422);
            }

            $this->userRepo->insert([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'role_id' => config('auth.roles.user'),
            ]);

            return response()->json([
                'message' => __('regisS'),
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => __('regisF'),
                'error' => $error,
            ], 500);
        }
    }
}
