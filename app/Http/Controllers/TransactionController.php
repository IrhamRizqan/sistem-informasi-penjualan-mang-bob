<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {}

    public function index()
    {
        $menus = Menu::where('stok', '>', 0)->get();
        return view('transaction.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        $transaction = $this->transactionService->create(
            Auth::id(),
            $validated['items'],
            $validated['bayar']
        );

        return redirect()->route('transaction.receipt', $transaction)
            ->with('success', 'Transaction completed successfully.');
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load('items.menu', 'user');
        return view('transaction.receipt', compact('transaction'));
    }

    public function history()
    {
        $transactions = Transaction::with('user')
            ->latest()
            ->paginate(10);

        return view('transaction.history', compact('transactions'));
    }

    public function detail(Transaction $transaction)
    {
        $transaction->load('items.menu', 'user');
        return view('transaction.detail', compact('transaction'));
    }
}
