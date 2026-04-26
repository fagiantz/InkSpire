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

        // --- Untuk sementara, simulasi login berhasil ---
        // Nanti ganti dengan panggilan ke backend Go:
        // $response = Http::post('http://localhost:8080/api/auth/login', [
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);
        // if ($response->failed()) {
        //     return back()->with('error', 'Login gagal, periksa email dan password.');
        // }
        // $data = $response->json();
        // session(['token' => $data['token'], 'user' => $data['user']]);
        // return redirect()->route('home');

        // Simulasi login sukses (pakai data dummy)
        session([
            'token' => 'dummy_token',
            'user' => [
                'id' => 1,
                'email' => $request->email,
                'name' => 'User Dummy',
                'role' => 'staff',
            ]
        ]);

        return redirect()->route('home');
    }

    public function logout()
    {
        // Hapus token dan data dari session
        session()->forget(['token', 'user']);
        return redirect()->route('login');
    }
}