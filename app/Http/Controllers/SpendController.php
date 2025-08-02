<?php
namespace App\Http\Controllers;

use App\Enums\FinancialPaymentMethod;
use App\Http\Requests\StoreSpendRequest;
use App\Services\SpendService;
use Illuminate\Http\Request;
class SpendController
{
    protected $service;

    public function __construct(SpendService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $spends = $this->service->getAllSpends();
        return view('spends.index', compact('spends'));
    }

    public function create()
    {
        $methods = FinancialPaymentMethod::cases();
        return view('spends.create', compact('methods'));
    }
    public function store(StoreSpendRequest $request)
    {
        $this->service->createSpend($request->validated());
        return redirect()->route('spends.index')->with('success', 'Gasto criado com sucesso.');
    }

    public function edit($id)
    {
        $methods = FinancialPaymentMethod::cases();
        $spend = $this->service->findSpendById($id);
        return view('spends.edit', compact('spend', 'methods'));
    }
    public function update(StoreSpendRequest $request, $id)
    {
        $this->service->updateSpend($id, $request->validated());
        return redirect()->route('spends.index')->with('success', 'Gasto atualizado com sucesso.');
    }
    public function show($id)
    {
        $methods = FinancialPaymentMethod::cases();
        $spend = $this->service->findSpendById($id);
        return view('spends.show', compact('spend', 'methods'));
    }

    public function destroy($id)
    {
        $this->service->deleteSpend($id);
        return redirect()->route('spends.index')->with('success', 'Gasto excluído com sucesso.');
    }
}