<style>
    .custom-navbar {
        background: linear-gradient(90deg, #1d8cf8 0%, #0d46b7 100%);
        border-radius: 0 0 20px 20px;
        /* Fully pill-shaped */
        padding: 10px 24px;
        box-shadow: 0 10px 25px rgba(13, 70, 183, 0.15);
        border: none;
        transition: all 0.3s ease;
    }

    .custom-navbar .navbar-brand {
        font-weight: 800;
        font-size: 1.6rem !important;
        letter-spacing: -0.5px;
    }

    .custom-navbar .nav-link-custom {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 500;
        /* padding: 8px 16px !important; */
        transition: color 0.2s ease, opacity 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .custom-navbar .nav-link-custom:hover {
        color: #ffffff;
        opacity: 1;
    }

    .cart-wrapper {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: background-color 0.2s ease;
    }

    .cart-wrapper:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .cart-badge {
        position: absolute;
        top: -3px;
        right: -3px;
        background-color: #ff0000;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 800;
        min-width: 17px;
        height: 17px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #0d46b7;
        /* Blend border color with right-side gradient */
        padding: 0 3px;
    }

    .user-greeting {
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0 16px 0 8px;
    }

    .btn-logout {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff !important;
        border: none;
        border-radius: 12px;
        padding: 8px 20px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn-logout:hover {
        background-color: rgba(255, 255, 255, 0.25);
    }

    .btn-logout:active {
        transform: scale(0.97);
    }
</style>

<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container-fluid">
            <!-- Brand Logo -->
            <a class="navbar-brand text-white fw-bold" href="/">InkSpire</a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links and Actions -->
            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-3">
                    @if (session('token'))
                        @if (!in_array(request()->route()->getName(), ['dashboard', 'orders.index']))
                            <li class="nav-item">
                                <a class="nav-link-custom fs-5" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                        @if (request()->route()->getName() !== 'katalog')
                            <li class="nav-item">
                                <a class="nav-link-custom fs-5" href="{{ route('katalog') }}">Katalog</a>
                            </li>
                        @endif
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto d-flex align-items-center flex-row flex-wrap gap-2 gap-lg-0">
                    @if (session('token'))
                        <!-- Cart Icon -->
                        <li class="nav-item">
                            <a class="cart-wrapper text-white" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart-fill fs-5"></i>
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="cart-badge">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                        </li>

                        <!-- User Greeting -->
                        <li class="nav-item">
                            <span class="user-greeting">Hello, {{ session('user')['name'] }}!</span>
                        </li>

                        <!-- Logout Button -->
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-logout">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>