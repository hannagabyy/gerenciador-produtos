<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background: linear-gradient(90deg, #007bff, #6610f2);">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('products.index') }}">
            <i class="bi bi-box-seam me-2"></i>Gerenciador de Produtos
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    <li class="nav-item me-3 text-white fw-semibold">
                        👋 Bem-vindo, {{ Auth::user()->name }}!
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm rounded-pill fw-semibold shadow-sm">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item me-2">
                        <a href="{{ route('login.form') }}" class="btn btn-light btn-sm rounded-pill fw-semibold shadow-sm">
                            <i class="bi bi-person me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register.form') }}" class="btn btn-outline-light btn-sm rounded-pill fw-semibold shadow-sm">
                            <i class="bi bi-pencil-square me-1"></i>Registrar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
