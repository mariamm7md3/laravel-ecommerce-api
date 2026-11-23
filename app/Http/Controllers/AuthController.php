<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function store(RegisterRequest $request)
    {
       $data = $request->validated();

       $user = User::create([
           'first_name' => $data['first_name'],
           'last_name' => $data['last_name'],
           'phone' => $data['phone'],
           'email' => $data['email'],
           'gender' => $data['gender'],
           'password' => Hash::make($data['password']),
           'date_of_birth' => $data['date_of_birth'],
       ]);

       $token = $user->createToken('auth_token')->plainTextToken;

       return $this->successResponse(
           __('messages.auth.registered'),
           [
               'token' => $token,
               'user' => new UserResource($user),
           ],
           201
       );
    }

    public function login(AuthRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => __('messages.auth.invalid_credentials'),
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse(
            __('messages.auth.logged_in'),
            [
                'token' => $token,
                'user' => new UserResource($user),
            ],
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(__('messages.auth.logged_out'));
    }


    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse(__('messages.auth.reset_link_sent'));
        }

        return $this->errorResponse(__('messages.auth.email_not_found'),404);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );


        if ($status === Password::PASSWORD_RESET) {
            return $this->successResponse(__('messages.auth.password_reset'));
        }

        return $this->errorResponse(__('messages.auth.invalid_token'),400);
    }


}
