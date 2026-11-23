<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(!Auth::attempt($request->only('email','password')))
        {
            return redirect()->back()->withErrors(['error'=>'Invalid Credentials'])->withInput();
        }

        if(!Auth::user()->is_admin)
        {
            Auth::logout();
            return redirect()->back()->withErrors(['error'=>'You are not authorized to access this page.'])->withInput();
        }
        $request->session()->regenerate();
        return redirect()->intended('/home');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
