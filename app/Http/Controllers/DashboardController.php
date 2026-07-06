<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $todayRevenue = Transaction::whereDate('tanggal', $today)->sum('total');
        $todayTransactions = Transaction::whereDate('tanggal', $today)->count();
        $menuCount = Menu::count();
        $lowStock = Menu::where('stok', '<=', 5)->count();

        $recentTransactions = Transaction::with('user')
            ->whereDate('tanggal', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'todayRevenue',
            'todayTransactions',
            'menuCount',
            'lowStock',
            'recentTransactions'
        ));
    }
}
