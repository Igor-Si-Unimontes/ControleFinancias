@extends('layouts.main')

@section('title', 'Nova Categoria de Gasto')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Adicionar Nova Categoria de Gasto</h1>
        <div class="divisor-underline mb-4"></div>
        <form action="{{ route('category_spends.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3">
                <a href="{{ route('category_spends.index') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Adicionar Nova Categoria de Gasto</button>
            </div>
        </form>
    </div>
@endsection