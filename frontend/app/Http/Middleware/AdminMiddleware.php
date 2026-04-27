<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        if (!$user || !isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('login')->with('error', 'Akses khusus admin.');
        }

        return $next($request);
    }
}