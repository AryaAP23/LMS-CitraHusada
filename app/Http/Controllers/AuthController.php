<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show login page.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Process login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/pembelajaran');
        }

        return back()->withErrors(["nik" => "Nomor induk atau kata sandi tidak cocok."]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
