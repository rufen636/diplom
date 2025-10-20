<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Отобразить главную страницу менеджера
     */
    public function index(): Response
    {
        // Статистика для дашборда
        $totalUsers = User::count();
        $activeUsers = User::whereNotNull('email_verified_at')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Статистика по договорам
        $totalContracts = \App\Models\Contract::count();
        $activeContracts = \App\Models\Contract::where('status', 'active')->count();
        $totalAmount = \App\Models\Contract::sum('amount');

        // Последние пользователи
        $recentUsers = User::latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at']);

        // Последние договоры
        $recentContracts = \App\Models\Contract::with('user')
            ->latest()
            ->take(5)
            ->get(['id', 'contract_number', 'title', 'user_id', 'amount', 'status', 'created_at']);

        return Inertia::render('Manager/Dashboard', [
            'stats' => [
                'totalUsers' => $totalUsers,
                'activeUsers' => $activeUsers,
                'newUsersThisMonth' => $newUsersThisMonth,
                'totalContracts' => $totalContracts,
                'activeContracts' => $activeContracts,
                'totalAmount' => $totalAmount,
            ],
            'recentUsers' => $recentUsers,
            'recentContracts' => $recentContracts,
        ]);
    }
}

