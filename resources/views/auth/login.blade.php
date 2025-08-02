@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6">
            <div class="card card-dark shadow-lg rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold text-success">Acesse seu controle financeiro</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>

                            @error('password')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input"
                                   name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Lembrar-me</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Entrar</button>
                        </div>

                        <div class="mt-4 d-flex justify-content-between small">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Esqueceu a senha?
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">
                                    Criar conta
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
