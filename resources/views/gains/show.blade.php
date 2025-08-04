@extends('layouts.main')

@section('title', 'Visualizar Ganho')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Visualizar Ganho</h1>
        <div class="divisor-underline mb-4"></div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $gain->name) }}" readonly>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="amount" class="form-label">Valor*</label>
                    <input type="text" class="form-control" id="amount" name="amount"
                        value="{{ old('amount', $gain->amount) }}" readonly>
                </div>


                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">Data*</label>
                    <input type="date" class="form-control" id="date" name="date"
                        value="{{ old('date', \Carbon\Carbon::parse($gain->date)->format('Y-m-d')) }}" readonly>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Descrição do ganho*</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description', $gain->description) }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <input type="hidden" class="form-control" id="user_id" name="user_id"
                        value ="{{ auth()->user()->id }}" readonly>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3">
                <a href="{{ route('gains.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
    </div>
@endsection
