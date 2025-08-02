<?php
namespace App\Http\Controllers;

use App\Enums\FinancialPaymentMethod;
use App\Http\Requests\StoreSpendRequest;
use App\Models\CategorySpend;
use App\Services\CategorySpendService;
use App\Services\SpendService;
use Illuminate\Http\Request;
class SpendController
{
    protected $service;
    protected $categorySpendService;

    public function __construct(SpendService $service, CategorySpendService $categorySpendService)
    {
        $this->service = $service;
        $this->categorySpendService = $categorySpendService;
    }

    public function index()
    {
        $categories = CategorySpend::with('spends')->get();
        $spends = $this->service->getAllSpends();
        return view('spends.index', compact('spends'));
    }

    public function create()
    {
        $categories = $this->categorySpendService->getAllCategorySpends();
        $methods = FinancialPaymentMethod::cases();
        return view('spends.create', compact('methods', 'categories'));
    }
    public function store(StoreSpendRequest $request)
    {
        $this->service->createSpend($request->validated());
        return redirect()->route('spends.index')->with('success', 'Gasto criado com sucesso.');
    }

    public function edit($id)
    {
        $categories = $this->categorySpendService->getAllCategorySpends();
        $methods = FinancialPaymentMethod::cases();
        $spend = $this->service->findSpendById($id);
        return view('spends.edit', compact('spend', 'methods', 'categories'));
    }
    public function update(StoreSpendRequest $request, $id)
    {
        $this->service->updateSpend($id, $request->validated());
        return redirect()->route('spends.index')->with('success', 'Gasto atualizado com sucesso.');
    }
    public function show($id)
    {
        $categories = $this->categorySpendService->getAllCategorySpends();
        $methods = FinancialPaymentMethod::cases();
        $spend = $this->service->findSpendById($id);
        return view('spends.show', compact('spend', 'methods', 'categories'));
    }

    public function destroy($id)
    {
        $this->service->deleteSpend($id);
        return redirect()->route('spends.index')->with('success', 'Gasto excluído com sucesso.');
    }
}