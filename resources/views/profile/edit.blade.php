@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6">
            <div class="card card-dark shadow-lg rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold text-success">Editar Perfil</h3>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') ?? $user->name }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') ?? $user->email }}" required>
                                   <div class="invalid-feedback">
                                       @error('email') {{ $message }} @enderror
                                   </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('home') }}" class="btn btn-danger text-white w-50">Voltar</a>
                            <button type="submit" class="btn btn-success w-50">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
