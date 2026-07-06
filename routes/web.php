<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isOwner()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('transaction.index');
    }
    return redirect()->route('login');
});

// Dashboard - Owner only
Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:owner')
        ->name('dashboard');
});

// Menu Management - Owner only
Route::middleware(['auth', 'prevent-back', 'role:owner'])->prefix('menu')->name('menu.')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::post('/', [MenuController::class, 'store'])->name('store');
    Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
    Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
});

// Transactions - Kasir only
Route::middleware(['auth', 'prevent-back', 'role:kasir'])->prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::get('/{transaction}/receipt', [TransactionController::class, 'receipt'])->name('receipt');
});

// Transaction History - Both roles
Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/history', [TransactionController::class, 'history'])->name('history');
    Route::get('/history/{transaction}', [TransactionController::class, 'detail'])->name('detail');
});

// Reports - Owner only
Route::middleware(['auth', 'prevent-back', 'role:owner'])->prefix('report')->name('report.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::post('/generate', [ReportController::class, 'generate'])->name('generate');
    Route::get('/{report}', [ReportController::class, 'show'])->name('show');
    Route::get('/{report}/pdf', [ReportController::class, 'pdf'])->name('pdf');
});

// API for charts
Route::middleware(['auth'])->get('/api/sales-chart', function () {
    $labels = [];
    $values = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $labels[] = $date->format('d M');
        $values[] = Transaction::whereDate('tanggal', $date)->sum('total');
    }

    return response()->json(['labels' => $labels, 'values' => $values]);
});

require __DIR__.'/auth.php';
