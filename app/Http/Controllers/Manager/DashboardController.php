<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $totalContracts = Contract::count();
        $activeContracts = Contract::where('status', 'active')->count();
        $totalAmount = Contract::sum('amount');

        // Последние пользователи
        $recentUsers = User::latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at']);

        // Последние договоры
        $recentContracts = Contract::with('user')
            ->latest()
            ->take(5)
            ->get(['id', 'contract_number', 'title', 'amount', 'status', 'created_at']);

        // Аналитика для графиков за последние 6 месяцев
        $months = collect(range(5, 0))->map(fn (int $offset) => now()->subMonths($offset));
        $monthlyLabels = $months->map(fn ($month) => $month->locale('ru')->translatedFormat('M Y'))->values();

        $monthlyContracts = $months->map(function ($month) {
            return Contract::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $monthlyRevenue = $months->map(function ($month) {
            return (float) Contract::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
        })->values();

        $statusDistribution = Contract::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

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
            'analytics' => [
                'monthlyContracts' => [
                    'labels' => $monthlyLabels,
                    'data' => $monthlyContracts,
                ],
                'monthlyRevenue' => [
                    'labels' => $monthlyLabels,
                    'data' => $monthlyRevenue,
                ],
                'contractStatus' => [
                    'labels' => ['Активные', 'Завершенные', 'Расторгнутые'],
                    'data' => [
                        (int) $statusDistribution->get('active', 0),
                        (int) $statusDistribution->get('completed', 0),
                        (int) $statusDistribution->get('terminated', 0),
                    ],
                ],
            ],
        ]);
    }
}

