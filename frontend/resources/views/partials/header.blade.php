<nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="/">InkSpire</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- <li class="nav-item">
                    @if (session('token'))
                    <a class="nav-link text-white" href="{{ route('home') }}">Beranda</a>
                    @else
                    <a class="nav-link text-white" href="{{ route('main') }}">Beranda</a>
                    @endif
                </li> --}}
                @if (session('token'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('katalog') }}">Katalog</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto d-flex align-items-center">
                @if (session('token'))
                    <li class="nav-item d-flex align-items-center me-3">
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
                    <!-- Teks Dashboard (hanya jika bukan halaman dashboard) -->
                    @if (request()->route()->getName() !== 'dashboard')
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link text-white" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endif
                    <!-- Tombol Logout -->
                    <li class="nav-item d-flex align-items-center">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm ms-2"
                                style="background-color: white; color: #0D95D2; border-radius: 20px; line-height: 1.5;">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <!-- Tombol Masuk untuk yang belum login -->
                    <li class="nav-item d-flex align-items-center">
                        <a href="{{ route('login') }}" class="btn btn-sm ms-2"
                            style="background-color: white; color: #0D95D2; border-radius: 20px; line-height: 1.5;">
                            Masuk
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>