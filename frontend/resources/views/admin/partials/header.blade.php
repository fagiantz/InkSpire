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
        transition: color 0.2s ease, opacity 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .custom-navbar .nav-link-custom:hover {
        color: #ffffff;
        opacity: 1;
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
                <ul class="navbar-nav ms-auto d-flex align-items-center flex-row flex-wrap gap-2 gap-lg-0">
                    @if (session('token'))
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