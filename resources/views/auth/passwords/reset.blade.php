@extends('layouts.app')

@section('title', 'Redefinir Senha')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <div class="card card-dark shadow-lg rounded-4" style="background-color: #1e1e1e; color: #f5f5f5;">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 fw-bold text-success">Redefinir sua senha</h3>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            required autocomplete="email" autofocus>

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
                            name="password"
                            required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirmar Senha</label>
                        <input id="password-confirm" type="password"
                            class="form-control"
                            name="password_confirmation"
                            required autocomplete="new-password">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Redefinir senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
