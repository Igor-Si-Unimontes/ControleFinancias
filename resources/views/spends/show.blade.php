@extends('layouts.main')

@section('title', 'Visualizar Gasto')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Visualizar Gasto</h1>
        <div class="divisor-underline mb-4"></div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $spend->name) }}" readonly>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="amount" class="form-label">Valor*</label>
                    <input type="text" class="form-control" id="amount" name="amount"
                        value="{{ old('amount', $spend->amount) }}" readonly>
                </div>


                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">Data*</label>
                    <input type="date" class="form-control" id="date" name="date"
                        value="{{ old('date', \Carbon\Carbon::parse($spend->date)->format('Y-m-d')) }}" readonly>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="category_spend_id" class="form-label">Categoria*</label>
                    <select name="category_spend_id" id="category_spend_id" class="form-select" disabled>
                        <option value="" disabled {{ old('category_spend_id', $spend->category_spend_id ?? '') == '' ? 'selected' : '' }}>
                            Selecione uma categoria
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_spend_id', $spend->category_spend_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="payment_method" class="form-label">Método de Pagamento*</label>
                    <select name="payment_method" id="payment_method" class="form-select" disabled>
                        <option value="" disabled
                            {{ old('payment_method', $spend->payment_method) ? '' : 'selected' }}>
                            Selecione um método de pagamento
                        </option>
                        @foreach ($methods as $method)
                            <option value="{{ $method->value }} "
                                {{ old('payment_method', $spend->payment_method) == $method->value ? 'selected' : '' }}>
                                {{ $method->label() }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Descrição do gasto*</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description', $spend->description) }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <input type="hidden" class="form-control" id="user_id" name="user_id"
                        value ="{{ auth()->user()->id }}" readonly>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3">
                <a href="{{ route('spends.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
    </div>
@endsection
