<?php

namespace App\Http\Controllers;

use App\Services\GainService;
use App\Services\SpendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
