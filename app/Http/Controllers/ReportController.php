<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Transaction;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService
    ) {}

    public function index()
    {
        $reports = Report::with('user')->latest('tanggal')->paginate(10);
        return view('report.index', compact('reports'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
        ]);

        $report = $this->reportService->generate(
            $validated['tanggal'],
            Auth::id()
        );

        return redirect()->route('report.show', $report)
            ->with('success', 'Report generated successfully.');
    }

    public function show(Report $report)
    {
        $transactions = Transaction::whereDate('tanggal', $report->tanggal)->get();
        return view('report.show', compact('report', 'transactions'));
    }

    public function pdf(Report $report)
    {
        $transactions = Transaction::whereDate('tanggal', $report->tanggal)->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('report.pdf', compact('report', 'transactions'));

        return $pdf->download('laporan-penjualan-' . $report->tanggal->format('Y-m-d') . '.pdf');
    }
}
