@extends('layouts.main')

@section('title', 'Editar Ganho')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Editar Ganho</h1>
        <div class="divisor-underline mb-4"></div>
        <form action="{{ route('gains.update', $gain->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $gain->name) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="amount" class="form-label">Valor*</label>
                    <input type="text" class="form-control" id="amount" name="amount"
                        value="{{ old('amount', $gain->amount) }}" required>
                </div>


                <div class="mb-3 col-md-6">
                    <label for="date" class="form-label">Data*</label>
                    <input type="date" class="form-control" id="date" name="date"
                        value="{{ old('date', \Carbon\Carbon::parse($gain->date)->format('Y-m-d')) }}" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Descrição do ganho*</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description', $gain->description) }}">
                </div>
                
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3">
                <a href="{{ route('gains.index') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Atualizar Ganho</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const amountInput = document.getElementById('amount');

            const originalRawValue = amountInput.value;

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

                let decimais = value.slice(-2);
                let inteiros = value.slice(0, -2);

                inteiros = inteiros.replace(/^0+(?!$)/, '');

                if (inteiros === '') {
                    inteiros = '0';
                }

                inteiros = inteiros.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                e.target.value = inteiros + ',' + decimais;
            });

            const form = amountInput.closest('form');
            if (form) {
                form.addEventListener('submit', e => {
                    if (amountInput.value === originalRawValue) {
                        amountInput.value = originalRawValue;
                        return;
                    }

                    let val = amountInput.value;

                    val = val.replace(/\./g, '').replace(',', '.');

                    let numVal = parseFloat(val);

                    if (isNaN(numVal)) {
                        e.preventDefault();
                        alert('Valor inválido!');
                        return false;
                    }

                    amountInput.value = numVal.toFixed(2);
                });
            }
        });
    </script>

@endsection
