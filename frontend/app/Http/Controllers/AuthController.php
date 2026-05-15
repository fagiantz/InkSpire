<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data = $this->authService->register(
            $request->email,
            $request->password,
            $request->name
        );

        if (isset($data['error'])) {
            return back()->with('error', $data['error'])->withInput();
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = $this->authService->login($request->email, $request->password);

        if (isset($data['error'])) {
            return back()->with('error', $data['error'])->withInput();
        }

        session([
            'token' => $data['token'],
            'user' => $data['user'],
        ]);

        if (isset($data['user']['role']) && $data['user']['role'] === 'staff') {
            return redirect()->route('admin.orders');
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        $this->authService->logout();           // Panggil backend Go (opsional, karena token tidak disimpan di server)
        session()->forget(['token', 'user']);   // Hapus token dan data user dari session Laravel
        return redirect()->route('login');      // Arahkan kembali ke halaman login
    }

}