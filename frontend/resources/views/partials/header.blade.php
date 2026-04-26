<nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand text-white fw-bold" href="/">InkSpire</a>
        
        <!-- Toggler untuk mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
            <!-- Menu kiri: Beranda & Katalog -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('katalog') }}">Katalog</a>
                </li>
            </ul>

            <!-- Bagian kanan: Dashboard (jika login) + Tombol -->
            <ul class="navbar-nav ms-auto">
                @if(session('token'))
                    <!-- Sudah login: Dashboard + Logout -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm ms-2"
                                    style="background-color: white; color: #0D95D2; border-radius: 20px; font-weight: 500;">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <!-- Belum login: tombol Masuk -->
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-sm ms-2"
                           style="background-color: white; color: #0D95D2; border-radius: 20px; font-weight: 500;">
                            Masuk
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>