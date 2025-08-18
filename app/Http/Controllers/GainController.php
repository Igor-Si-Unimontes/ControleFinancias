<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGainRequest;
use App\Services\GainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GainController extends Controller
{
    protected $service;

    public function __construct(GainService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $gains = $this->service->getAllGains();
        return view('gains.index', compact('gains'));
    }

    public function create()
    {
        return view('gains.create');
    }

    public function store(StoreGainRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->service->createGain($data);
        return redirect()->route('gains.index')->with('success', 'Ganho criado com sucesso.');
    }

    public function edit($id)
    {
        $gain = $this->service->findGainById($id);
        return view('gains.edit', compact('gain'));
    }

    public function update(StoreGainRequest $request, $id)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->service->updateGain($id, $data);
        return redirect()->route('gains.index')->with('success', 'Ganho atualizado com sucesso.');
    }

    public function show($id)
    {
        $gain = $this->service->findGainById($id);
        return view('gains.show', compact('gain'));
    }

    public function destroy($id)
    {
        $this->service->deleteGain($id);
        return redirect()->route('gains.index')->with('success', 'Ganho excluído com sucesso.');
    }
}
