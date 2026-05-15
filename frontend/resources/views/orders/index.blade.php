<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Saya - InkSpire</title>
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

        .order-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .product-placeholder {
            background-color: #e9ecef;
            border-radius: 12px;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('orders.index') }}">
                            <i class="bi bi-cart-fill"></i>
                            Pesanan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2 class="fw-bold">PESANAN</h2>
                <h5 class="fw-bold mb-3">Riwayat Pesanan</h5>

                @forelse ($orders as $order)
                    <div class="order-card d-flex flex-column flex-md-row align-items-md-center gap-3">
                        <div class="product-placeholder">
                            <i class="bi bi-image" style="font-size: 2.5rem; color: #38BDF8;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold">Pesanan #{{ $order['no_pesanan'] }}</h6>
                            <p class="mb-1">Status:
                                @php
                                    $badgeClass = match ($order['status']) {
                                        'unpaid' => 'bg-warning text-dark',
                                        'paid' => 'bg-primary',
                                        'process' => 'bg-info',
                                        'done' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                    $statusText = match ($order['status']) {
                                        'unpaid' => 'Belum dibayar',
                                        'paid' => 'Sudah dibayar',
                                        'process' => 'Diproses',
                                        'done' => 'Selesai',
                                        default => $order['status'],
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                            </p>
                            <p class="mb-0 text-muted">Tanggal:
                                {{ \Carbon\Carbon::parse($order['order_date'])->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-md-end">
                            <p class="fw-bold fs-5">Rp {{ number_format($order['total_harga'], 0, ',', '.') }}</p>
                            <a href="{{ route('orders.detail', $order['id_pesanan']) }}" class="btn btn-sm"
                                style="background-color: #38BDF8; color: white;">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="mt-3">Belum ada riwayat pesanan.</p>
                        <a href="{{ route('katalog') }}" class="btn btn-primary"
                            style="background-color: #38BDF8; border: none;">Mulai Belanja</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>
</body>

</html>
