@extends('layouts.main')

@section('title', 'Novo Ganho')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <h1 class="mb-2 titulo">Adicionar Novo Ganho</h1>
        <div class="divisor-underline mb-4"></div>
        <form action="{{ route('gains.store') }}" method="POST">
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
                    <label for="description" class="form-label">Descrição do ganho*</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ old('description') }}">
                </div>
                <div class="mb-3 col-md-6">
                    <input type="hidden" class="form-control" id="user_id" name="user_id"
                        value ="{{ auth()->user()->id }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2 mt-3">
                <a href="{{ route('gains.index') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Adicionar Novo Ganho</button>
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
