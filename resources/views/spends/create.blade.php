@extends('layouts.main')

@section('title', 'Novo Gasto')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Adicionar Novo Gasto</h1>
        <div class="divisor-underline mb-4"></div>
        <form action="{{ route('spends.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="amount" class="form-label">Valor*</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}"
                        required>
                </div>


                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">Data*</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="category_spend_id" class="form-label">Categoria*</label>
                    <select name="category_spend_id" id="category_spend_id" class="form-select" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_spend_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="payment_method" class="form-label">Método de Pagamento*</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="" disabled selected>Selecione um método de pagamento</option>
                        @foreach ($methods as $method)
                            <option value="{{ $method->value }}"
                                {{ old('payment_method') == $method->value ? 'selected' : '' }}>{{ $method->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Descrição do gasto*</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description') }}">
                </div>
               
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3">
                <a href="{{ route('spends.index') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Adicionar Novo Gasto</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const amountInput = document.getElementById('amount');

            amountInput.addEventListener('input', e => {
                let value = e.target.value;

                value = value.replace(/\D/g, '');

                if (value.length === 0) {
                    e.target.value = '';
                    return;
                }

                if (value.length > 12) {
                    value = value.slice(0, 12);
                }

                if (value.length < 3) {
                    value = value.padStart(3, '0');
                }

                let decimais = value.slice(-2);
                let inteiros = value.slice(0, -2);

                inteiros = inteiros.replace(/^0+(?!$)/, '');

                inteiros = inteiros.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                e.target.value = inteiros + ',' + decimais;
            });

            const form = amountInput.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    let val = amountInput.value;
                    val = val.replace(/\./g, '').replace(',', '.');
                    amountInput.value = val;
                });
            }
        });
    </script>

@endsection
