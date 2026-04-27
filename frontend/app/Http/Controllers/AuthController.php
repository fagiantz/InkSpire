<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Placeholder, nanti panggil backend Go
        return back()->with('error', 'Fitur registrasi belum tersedia.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Simulasi login (nanti diganti panggilan ke backend Go)
    if ($request->email === 'staff@example.com' && $request->password === 'password123') {
        session([
            'token' => 'dummy_token_staff',
            'user' => [
                'id' => 1,
                'email' => 'staff@example.com',
                'name' => 'Staff Admin',
                'role' => 'staff',
            ]
        ]);
        return redirect()->route('admin.dashboard');
    } else {
        // User biasa
        session([
            'token' => 'dummy_token_user',
            'user' => [
                'id' => 2,
                'email' => $request->email,
                'name' => 'User Dummy',
                'role' => 'user',
            ]
        ]);
        return redirect()->route('home');
    }
}

    public function logout()
    {
        // Hapus token dan data dari session
        session()->forget(['token', 'user']);
        return redirect()->route('login');
    }
}