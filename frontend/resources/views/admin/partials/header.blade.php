<nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-white fw-bold mb-0 fs-3" href="#">InkSpire</a>
        <ul class="navbar-nav ms-auto d-flex align-items-center">
            <li class="nav-item me-3">
                <p class="text-white fs-6 m-0">Hello, {{ session('user')['name'] }}!</p>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm bg-light" style="color: #0D95D2;">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>