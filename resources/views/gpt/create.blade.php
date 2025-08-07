@extends('layouts.main')

@section('title', 'Novo Ganho')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Adicionar Novo gasto por ia</h1>
        <div class="divisor-underline mb-4"></div>
            <form method="POST" action="{{ url('/gasto/gpt') }}">
                @csrf
                <input type="text" name="texto" class="form-control" placeholder="Descreva seu gasto: Ex: Gastei 15 reais hoje com lanche">
                <button type="submit" class="btn btn-success mt-2">Adicionar Novo Gasto</button>
            </form>
        </div>
    </div>
@endsection
@section('styles')
   <style>
    input::placeholder {
        color: white !important;
        opacity: 0.3 !important;
    }
</style>
@endsection