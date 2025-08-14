<?php

namespace App\Http\Controllers;

use App\Services\GainService;
use App\Services\SpendService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class ReportController extends Controller
{
    protected $spendService;
    protected $gainService;
    public function __construct(SpendService $spendService, GainService $gainService)
    {
        $this->spendService = $spendService;
        $this->gainService = $gainService;
    }
    public function index()
    {
        $spends = $this->spendService->getAllSpends();
        $gains = $this->gainService->getAllGains();
        $totalSpent = $this->spendService->sumAmountsMonth();
        $totalGained = $this->gainService->sumAmountsMonth();
        $totalSpentByCategory = $this->spendService->totalSpentByCategory();

        return view('reports.index', compact('spends', 'gains', 'totalSpent', 'totalGained', 'totalSpentByCategory'));
    }
    public function filterForDateRange(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate || !$endDate) {
            return response()->json([
                'success' => false,
                'message' => 'As datas de início e fim são obrigatórias.'
            ]);
        }
        try {
            $spends = $this->spendService->filtersForDateRange($startDate, $endDate);
            $gains = $this->gainService->filtersForDateRange($startDate, $endDate);
            $totalSpends = $spends->sum('amount');
            $totalGains = $gains->sum('amount');
            $totalBalance = $totalGains - $totalSpends;
            return response()->json([
                'success' => true,
                'spends' => $spends,
                'gains' => $gains,
                'total_spends' => $totalSpends,
                'total_gains' => $totalGains,
                'total_balance' => $totalBalance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar os dados: ' . $e->getMessage()
            ]);
        }
    }
   public function generatePdf(Request $request)
    {
        $startDate = $request->query('start_date'); // usando query pois vamos chamar via GET
        $endDate = $request->query('end_date');

        try {
            $spends = $this->spendService->filtersForDateRange($startDate, $endDate);
            $gains = $this->gainService->filtersForDateRange($startDate, $endDate);

            $totalSpends = $spends->sum('amount');
            $totalGains = $gains->sum('amount');
            $totalBalance = $totalGains - $totalSpends;

            $data = [
                'spends' => $spends,
                'gains' => $gains,
                'total_spends' => $totalSpends,
                'total_gains' => $totalGains,
                'total_balance' => $totalBalance,
                'start_date' => $startDate,
                'end_date' => $endDate
            ];

            $pdf = FacadePdf::loadView('reports.pdf', $data);
            return $pdf->download('relatorio.pdf');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Erro ao gerar PDF: ' . $e->getMessage()
            ]);
        }
    }

}
