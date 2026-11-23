<?php

namespace App\Http\Controllers;

use App\Models\UserFcmToken;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        UserFcmToken::updateOrCreate(
            ['token' => $request->token],
            ['user_id'=> $request->user()->id]
        );

        return response()->json(['message' => 'تم حفظ التوكن بنجاح']);
    }
}
