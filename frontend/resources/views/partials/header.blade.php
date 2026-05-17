<nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
    <div class="container">
        <a class="navbar-brand text-white fw-bold fs-3" href="/">InkSpire</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (session('token'))
                    <!-- Teks Dashboard (hanya jika bukan halaman dashboard) -->
                    @if (request()->route()->getName() !== 'dashboard')
                        <li class="nav-item">
                            <a class="nav-link text-white fs-5" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endif
                    @if (request()->route()->getName() !== 'katalog')
                        <li class="nav-item">
                            <a class="nav-link text-white fs-5" href="{{ route('katalog') }}">Katalog</a>
                        </li>
                    @endif
                @endif
            </ul>

            <ul class="navbar-nav ms-auto d-flex align-items-center">
                @if (session('token'))
                    <li class="nav-item me-2">
                        <a class="nav-link text-white position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.6rem;">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <p class="text-white fs-6 m-0">Hello, {{ session('user')['name'] }}!</p>
                    </li>
                    <!-- Tombol Logout -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm ms-2 bg-light" style="color: #0D95D2;">
                                Logout
                            </button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>