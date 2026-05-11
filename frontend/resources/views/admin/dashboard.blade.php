<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #FEFEFD;
        }

        .sidebar {
            background-color: #fff;
            border-right: 2px solid #38BDF8;
            min-height: calc(100vh - 56px);
            padding: 30px 20px;
        }

        .sidebar .nav-link {
            color: #6c757d;
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link.active {
            background-color: #E6F4FE;
            color: #0D95D2;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
        }

        .main-content {
            background-color: #F8F9FA;
            padding: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            transition: 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #38BDF8;
        }

        .stat-label {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-sub {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <!-- Header Admin -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white fw-bold mb-0" href="#">InkSpire</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm"
                    style="background-color: white; color: #0D95D2; border-radius: 20px;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders') }}">
                            <i class="bi bi-cart-fill"></i>
                            Pesanan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2 class="fw-bold mb-2">DASHBOARD</h2>
                <h5 class="fw-bold mb-4">Statistik penjualan</h5>

                <div class="row g-4">
                    <!-- Pesanan Baru Hari ini -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-label">Pesanan Baru (Hari ini)</div>
                            <div class="stat-number">{{ $data['new_orders_today'] ?? 0 }}</div>
                            <div class="stat-sub mt-2">Belum diproses: {{ $data['unpaid_today'] ?? 0 }}</div>
                        </div>
                    </div>
                    <!-- Pesanan Selesai -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-label">Pesanan Selesai</div>
                            <div class="stat-number">{{ $data['done_orders'] ?? 0 }}</div>
                        </div>
                    </div>
                    <!-- Total Pesanan -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-label">Total Pesanan</div>
                            <div class="stat-number">{{ $data['total_orders'] ?? 0 }}</div>
                        </div>
                    </div>
                    <!-- Total Pendapatan -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-label">Total Pendapatan</div>
                            <div class="stat-number">Rp {{ number_format($data['total_revenue'] ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
