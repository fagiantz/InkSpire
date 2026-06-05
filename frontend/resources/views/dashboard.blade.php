<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F7FC;
            color: #1E293B;
            margin: 0;
        }

        .sidebar-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 24px 16px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.02);
            border: none;
        }

        .sidebar-card .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #64748B;
            font-weight: 600;
            border-radius: 12px;
            margin-bottom: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-card .nav-link:hover {
            background-color: #F8FAFC;
            color: #0F172A;
        }

        .sidebar-card .nav-link.active {
            background-color: #EBF3FF;
            color: #2563EB;
        }

        .dashboard-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0F172A;
            margin-top: 10px;
            margin-bottom: 8px;
        }

        .dashboard-subtitle {
            font-size: 0.95rem;
            color: #64748B;
            margin-bottom: 36px;
        }

        .orders-section-card {
            background-color: #ffffff;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.02);
            border: none;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 24px;
        }

        .order-item-card {
            background-color: #F4F8FD;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 16px;
            border: none;
            display: flex;
            align-items: center;
            gap: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .order-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.04);
        }

        .product-image-container {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background-color: #E0ECFC;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-info-col {
            flex-grow: 1;
        }

        .product-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
        }

        .order-meta-text {
            font-size: 0.875rem;
            color: #64748B;
            margin-bottom: 2px;
        }

        .status-badge-custom {
            display: inline-block;
            font-size: 0.75rem;
            padding: 4px 12px;
            font-weight: 600;
            border-radius: 50px;
            margin-left: 6px;
        }

        .btn-detail-custom {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-detail-custom:hover {
            background-color: #1D4ED8;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-detail-custom:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    @include('partials.header')

    <div class="container-fluid py-4">

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="sidebar-card">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                Pesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-lg-10 col-md-8">
                <h1 class="dashboard-title">Dashboard</h1>
                <p class="dashboard-subtitle">Kelola seluruh pesanan custom printing Anda.</p>

                <div class="orders-section-card">
                    <h4 class="section-title">Pesanan Aktif</h4>

                    <div class="orders-list">
                        @forelse ($orders as $order)
                            @php
                                $statusText = match ($order['status']) {
                                    'unpaid' => 'Belum dibayar',
                                    'paid' => 'Sudah dibayar',
                                    'process' => 'Diproses',
                                    'done' => 'Selesai',
                                    default => $order['status'],
                                };
                            @endphp

                            <div class="order-item-card flex-column flex-sm-row">
                                <!-- Gambar Produk -->
                                <div class="product-image-container">
                                    @if (count($order['items']) > 0 && !empty($order['items'][0]['produk']['image_produk']))
                                        <img src="{{ route('products.image', $order['items'][0]['produk']['image_produk']) }}"
                                            alt="{{ $order['items'][0]['produk']['nama_produk'] ?? '' }}">
                                    @else
                                        <i class="bi bi-image text-primary fs-3"></i>
                                    @endif
                                </div>

                                <!-- Detail Produk -->
                                <div class="order-info-col text-center text-sm-start">
                                    <h6 class="product-name">
                                        @if (count($order['items']) > 0)
                                            {{ $order['items'][0]['produk']['nama_produk'] ?? 'Produk tidak diketahui' }}
                                            @if (count($order['items']) > 1)
                                                <span class="text-muted small font-normal"> (+{{ count($order['items']) - 1 }} item
                                                    lainnya)</span>
                                            @endif
                                        @else
                                            Tidak ada produk
                                        @endif
                                    </h6>
                                    <p class="order-meta-text">Jumlah : {{ collect($order['items'])->sum('kuantitas') }} pcs
                                    </p>
                                    <p class="order-meta-text d-flex align-items-center">
                                        Status : 
                                        @php
                                            $badgeStyle = match ($order['status']) {
                                                'unpaid' => 'background-color: #F59E0B; color: #ffffff;',
                                                'paid' => 'background-color: #2563EB; color: #ffffff;',
                                                'process' => 'background-color: #0D95D2; color: #ffffff;',
                                                'done' => 'background-color: #10B981; color: #ffffff;',
                                                default => 'background-color: #64748B; color: #ffffff;',
                                            };
                                        @endphp
                                        <span class="status-badge-custom" style="{{ $badgeStyle }}">{{ $statusText }}</span>
                                    </p>
                                </div>

                                <!-- Harga & Aksi -->
                                <div class="text-center text-sm-end">
                                    <p class="fw-bold fs-5 mb-2 text-primary">Rp
                                        {{ number_format($order['total_harga'], 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('orders.detail', $order['id_pesanan']) }}"
                                        class="btn-detail-custom">Detail</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="mt-3 text-muted">Belum ada pesanan aktif.</p>
                                <a href="{{ route('katalog') }}"
                                    class="btn-detail-custom px-4 py-2 mt-2 d-inline-block">Mulai Belanja</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>