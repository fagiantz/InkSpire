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
        body { font-family: 'Roboto', sans-serif; background-color: #FEFEFD; }
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

    <div class="container py-4">
        <h2 class="fw-bold">PESANAN</h2>
        <h5 class="fw-bold mb-3">Riwayat Pesanan</h5>

        @forelse ($orders as $order)
            <div class="order-card d-flex flex-column flex-md-row align-items-md-center gap-3">
                <!-- Gambar Produk (placeholder) -->
                <div class="product-placeholder">
                    <i class="bi bi-image" style="font-size: 2.5rem; color: #38BDF8;"></i>
                </div>
                <!-- Detail Pesanan -->
                <div class="flex-grow-1">
                    <h6 class="fw-bold">Pesanan #{{ $order['no_pesanan'] }}</h6>
                    <p class="mb-1">Jumlah Item: {{ count($order['items'] ?? []) }}</p>
                    <p class="mb-1">Status:
                        <span class="badge
                            @if($order['status'] == 'unpaid') bg-warning text-dark
                            @elseif($order['status'] == 'process') bg-info
                            @elseif($order['status'] == 'done') bg-success
                            @endif">
                            {{ $order['status'] }}
                        </span>
                    </p>
                    <p class="mb-0 text-muted">Tanggal: {{ \Carbon\Carbon::parse($order['order_date'])->format('d M Y, H:i') }}</p>
                </div>
                <!-- Total & Aksi -->
                <div class="text-md-end">
                    <p class="fw-bold fs-5">Rp {{ number_format($order['total_harga'], 0, ',', '.') }}</p>
                    <a href="{{ route('orders.detail') }}" class="btn btn-sm" style="background-color: #38BDF8; color: white;">Detail</a>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="mt-3">Belum ada riwayat pesanan.</p>
                <a href="{{ route('katalog') }}" class="btn btn-primary" style="background-color: #38BDF8; border: none;">Mulai Belanja</a>
            </div>
        @endforelse
    </div>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>
</body>
</html>