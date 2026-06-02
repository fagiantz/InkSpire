<?php

namespace App\Http\Controllers;

use App\Services\AdminService;

class AdminDashboardController extends Controller
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $user = session('user', []);
        if (!isset($user['role']) || $user['role'] !== 'staff') {
            return redirect()->route('home')->with('error', 'Akses khusus admin.');
        }

        $stats = $this->adminService->getStats();
        $data = $stats['data'] ?? [];

        return view('admin.dashboard', compact('data'));
    }
}