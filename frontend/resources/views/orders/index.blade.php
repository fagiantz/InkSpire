<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Saya - InkSpire</title>
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

        .page-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0F172A;
            margin-top: 10px;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: #64748B;
            margin-bottom: 36px;
        }

        .order-card-custom {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 24px 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.03);
            border: none;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .order-card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.06);
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

        .product-image-container {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            background-color: #E0ECFC;
            /* Soft blue placeholder background matching mockup */
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
            font-size: 1.1rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .order-meta-text {
            font-size: 0.9rem;
            color: #475569;
            margin-bottom: 4px;
        }

        .order-date-text {
            font-size: 0.825rem;
            color: #94A3B8;
            margin-top: 12px;
            font-weight: 500;
        }

        .order-total-price {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0F172A;
            white-space: nowrap;
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
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('orders.index') }}">
                                Pesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-lg-10 col-md-8">
                <h1 class="page-title">PESANAN</h1>
                <p class="page-subtitle">Riwayat Pesanan</p>

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

                            $badgeClass = match ($order['status']) {
                                'unpaid' => 'bg-warning text-dark',
                                'paid' => 'bg-primary text-white',
                                'process' => 'bg-info text-white',
                                'done' => 'bg-success text-white',
                                default => 'bg-secondary text-white',
                            };

                            $firstItem = count($order['items'] ?? []) > 0 ? $order['items'][0] : null;
                            $unitPrice = 0;
                            if ($firstItem) {
                                $unitPrice = $firstItem['kuantitas'] > 0 ? ($firstItem['harga_order'] / $firstItem['kuantitas']) : $firstItem['harga_order'];
                            }
                        @endphp

                        <div class="order-card-custom flex-column flex-md-row">
                            <!-- Gambar Produk -->
                            <div class="product-image-container">
                                @if ($firstItem && !empty($firstItem['produk']['image_produk']))
                                    <img src="{{ route('products.image', $firstItem['produk']['image_produk']) }}"
                                        alt="{{ $firstItem['produk']['nama_produk'] ?? '' }}">
                                @else
                                    <i class="bi bi-image text-primary fs-3"></i>
                                @endif
                            </div>

                            <!-- Detail Produk -->
                            <div class="order-info-col text-center text-md-start">
                                <h6 class="product-name">
                                    @if ($firstItem)
                                        {{ $firstItem['produk']['nama_produk'] ?? 'Produk tidak diketahui' }}
                                        @if (count($order['items']) > 1)
                                            <span class="text-muted small font-normal"> (+{{ count($order['items']) - 1 }} item
                                                lainnya)</span>
                                        @endif
                                    @else
                                        Tidak ada produk
                                    @endif
                                </h6>
                                <p class="order-meta-text">No. Pesanan: #{{ $order['no_pesanan'] }}</p>
                                @if ($firstItem)
                                    <p class="order-meta-text">Jumlah: {{ collect($order['items'])->sum('kuantitas') }}x</p>
                                @endif
                                <p
                                    class="order-meta-text d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2">
                                    Status Pesanan:
                                    <span class="badge {{ $badgeClass }} rounded-pill"
                                        style="font-size: 0.75rem; padding: 4px 12px; font-weight: 600;">
                                        {{ $statusText }}
                                    </span>
                                </p>

                                <div class="order-date-text">
                                    <span class="local-datetime"
                                        data-utc="{{ \Carbon\Carbon::parse($order['order_date'])->toIso8601String() }}">
                                        {{ \Carbon\Carbon::parse($order['order_date'])->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Total Harga & Aksi -->
                            <div class="text-center text-md-end mt-3 mt-md-0">
                                <div class="order-total-price mb-3">
                                    Rp {{ number_format($order['total_harga'], 0, ',', '.') }}
                                </div>
                                <a href="{{ route('orders.detail', $order['id_pesanan']) }}"
                                    class="btn-detail-custom d-inline-block">
                                    Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 bg-white rounded-5 shadow-sm">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="mt-3 text-muted">Belum ada riwayat pesanan.</p>
                            <a href="{{ route('katalog') }}" class="btn-detail-custom px-4 py-2 mt-2 d-inline-block"
                                style="background-color: #2563EB; color: white; text-decoration: none; border-radius: 10px; font-weight: 600;">Mulai
                                Belanja</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")

    <script>
        document.querySelectorAll('.local-datetime').forEach(function (el) {
            const utcDateStr = el.getAttribute('data-utc');
            if (utcDateStr) {
                const date = new Date(utcDateStr);
                if (!isNaN(date.getTime())) {
                    const day = date.getDate().toString().padStart(2, '0');
                    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    const month = monthNames[date.getMonth()];
                    const year = date.getFullYear();
                    const hour = date.getHours().toString().padStart(2, '0');
                    const minute = date.getMinutes().toString().padStart(2, '0');
                    el.textContent = `${day} ${month} ${year} — ${hour}:${minute} WIB`;
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>