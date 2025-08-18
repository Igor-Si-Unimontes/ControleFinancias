<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorySpendRequest;
use App\Services\CategorySpendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->service->createCategorySpend($data);
        return redirect()->route('category_spends.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function edit($id)
    {
        if (!$this->service->isTheCategoryMine($id)) {
            return redirect()->route('category_spends.index')->with('error', 'Você só pode editar as categorias que criou.');
        }
        $categorySpend = $this->service->findCategorySpendById($id);
        return view('category_spends.edit', compact('categorySpend'));
    }
    public function update(StoreCategorySpendRequest $request, $id)
    {
        if (!$this->service->isTheCategoryMine($id)) {
            return redirect()->route('category_spends.index')->with('error', 'Você só pode editar as categorias que criou.');
        }
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->service->updateCategorySpend($id, $data);
        return redirect()->route('category_spends.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy($id)
    {   
        if (!$this->service->isTheCategoryMine($id)) {
            return redirect()->route('category_spends.index')->with('error', 'Você só pode excluir as categorias que criou.');
        }
        $this->service->deleteCategorySpend($id);
        return redirect()->route('category_spends.index')->with('success', 'Categoria excluída com sucesso.');
    }
}