@extends('layouts.app')

@section('content')
<div class="container my-5 d-flex justify-content-center">
    <div class="card shadow-sm border-0 rounded-4" style="max-width: 500px; width: 100%;">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="bi bi-person-plus-fill me-2"></i>Registrar Usuário
                </h2>
            </div>

    
            <form action="{{ route('register.form') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nome: *</label>
                    <input type="text" class="form-control text-center" id="name" name="name" 
                           value="{{ old('name') }}" required>
                    <div class="invalid-feedback text-center">Informe seu nome.</div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">E-mail: *</label>
                    <input type="email" class="form-control text-center" id="email" name="email"
                           value="{{ old('email') }}" required>
                    <div class="invalid-feedback text-center">Informe um e-mail válido.</div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Senha: *</label>
                    <input type="password" class="form-control text-center" id="password" name="password" required>
                    <div class="invalid-feedback text-center">Informe uma senha.</div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Senha: *</label>
                    <input type="password" class="form-control text-center" id="password_confirmation" 
                           name="password_confirmation" required>
                    <div class="invalid-feedback text-center">Confirme sua senha.</div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Registrar
                    </button>
                </div>
            </form>

            <p class="text-center mt-4 mb-0">
                Já tem conta?
                <a href="{{ route('login.form') }}" class="text-decoration-none fw-semibold">
                    Faça login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
