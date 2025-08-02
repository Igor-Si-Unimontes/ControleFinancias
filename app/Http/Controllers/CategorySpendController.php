<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorySpendRequest;
use App\Services\CategorySpendService;
use Illuminate\Http\Request;

class CategorySpendController extends Controller
{
    protected $service;

    public function __construct(CategorySpendService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $spends = $this->service->getAllCategorySpends();
        return view('category_spends.index', compact('spends'));
    }

    public function create()
    {
        return view('category_spends.create');
    }
    public function store(StoreCategorySpendRequest $request)
    {
        $this->service->createCategorySpend($request->validated());
        return redirect()->route('category_spends.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function edit($id)
    {
        $categorySpend = $this->service->findCategorySpendById($id);
        return view('category_spends.edit', compact('categorySpend'));
    }
    public function update(StoreCategorySpendRequest $request, $id)
    {
        $this->service->updateCategorySpend($id, $request->validated());
        return redirect()->route('category_spends.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $this->service->deleteCategorySpend($id);
        return redirect()->route('category_spends.index')->with('success', 'Categoria excluída com sucesso.');
    }
}