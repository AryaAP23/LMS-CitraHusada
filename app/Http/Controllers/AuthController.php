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
     * Process login attempt for API.
     */
    public function loginApi(Request $request)
    {
        try {
            $credentials = $request->validate([
                'nik' => 'required|string',
                'password' => 'required|string',
            ]);

            // Debug: find user to see if they exist
            $user = \App\Models\User::where('nik', $credentials['nik'])->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User dengan NIK tersebut tidak ditemukan',
                    'data' => null
                ], 401);
            }

            if (Auth::attempt($credentials)) {
                // Session akan ter-set otomatis oleh Auth::attempt()
                $user = Auth::user();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'user' => $user,
                        'redirect' => '/pembelajaran'
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Password salah untuk user dengan NIK ini',
                'data' => null
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan login: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Logout user for API.
     */
    public function logoutApi(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan logout',
                'data' => null
            ], 500);
        }
    }
    /**
     * Logout user (Web-based).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}