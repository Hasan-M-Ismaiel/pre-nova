<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->intended(
                    route('admin.dashboard')
                );
            }

            if (auth()->user()->role === 'specialist') {
                return redirect()->intended(
                    route('specialist.dashboard')
                );
            }

            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account does not have a valid role.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}