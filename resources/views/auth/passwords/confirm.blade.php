@extends('layouts.app')

@section('title', 'Redefinir Senha')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6">
            <div class="card card-dark shadow-lg rounded-4" style="background-color: #1e1e1e; border: none; color: #f1f1f1;">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold text-success">Confirme sua senha</h3>

                    <p class="text-center mb-4">Por favor, confirme sua senha antes de continuar.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input id="password" type="password"
                                   class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Confirmar Senha</button>
                        </div>

                        <div class="mt-4 text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-success">
                                    Esqueceu sua senha?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
