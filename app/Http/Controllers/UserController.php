<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class
UserController extends Controller
{
    use ApiResponseTrait;
    use ImageTrait;

    public function show(Request $request)
    {
        $user = $request->user();

        return $this->successResponse(
            __('messages.user.fetched'),
            new UserResource($user),
        );
    }

    public function update(UpdateProfileRequest $request )
    {
       $user = $request->user();
       $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->updateImage(
                $request->file('photo'),
                $user->photo,
                'users'
            );
        }

        $user->update($data);

        return $this->successResponse(
            __('messages.user.updated'),
            new UserResource($user),
        );
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password , $user->password ))
        {
            return $this->errorResponse(__('messages.user.wrong_password'), 422);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return $this->successResponse(__('messages.user.password_changed'));
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $this->deleteImage($user->photo);
        $user->currentAccessToken()->delete();
        $user->delete();

        return $this->successResponse(__('messages.user.deleted'));
    }
}
