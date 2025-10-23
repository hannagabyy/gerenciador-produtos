@extends('layouts.app')

@section('content')
        <h2>Login</h2>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <p class="mt-3">Não tem conta? <a href="{{ route('register.form') }}">Registre-se</a></p>
    </div>
 @endsection
    
    @section('scripts')
    <script>
        console.log('kaaaaaaaaaaaaaaaaa');
            axios.post('/login', { 
            email: 'user@example.com', 
            password: 'password' 
        })
        .then(response => {
            console.log(response);
            // 1. Sucesso no login, pega o token
            const token = response.data.token;
            
            // 2. Salva o token para ser usado em outras páginas
            localStorage.setItem('api_token', token); 
            
            // 3. Redireciona o usuário para a página principal
            // window.location.href = '/'; // Ou '/produtos', '/dashboard', etc.

        })
        .catch(error => {
            // 4. ADICIONADO: Tratamento de erro
            console.error('Erro no login:', error.response ? error.response.data : error.message);
            alert('Login ou senha inválidos!');
        });

    </script>
    @endsection
