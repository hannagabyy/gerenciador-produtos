@extends('layouts.app')

@section('content')
<div class="container my-5 d-flex justify-content-center">
    <div class="card shadow-sm border-0 rounded-4" style="max-width: 450px; width: 100%;">
        <div class="card-body p-4">

            
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="bi bi-person-circle me-2"></i>Login
                </h2>
            </div>


            <form action="{{ route('login') }}" method="POST" id="login-form" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">E-mail:</label>
                    <input type="email" class="form-control text-center" id="email" 
                           name="email" value="{{ old('email') }}" required>
                    <div class="invalid-feedback text-center">
                        Informe um e-mail válido.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Senha:</label>
                    <input type="password" class="form-control text-center" id="password" 
                           name="password" required>
                    <div class="invalid-feedback text-center">
                        Informe sua senha.
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                    </button>
                </div>
            </form>

            <p class="text-center mt-4 mb-0">
                Não tem conta?
                <a href="{{ route('register.form') }}" class="text-decoration-none fw-semibold">
                    Registre-se
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
