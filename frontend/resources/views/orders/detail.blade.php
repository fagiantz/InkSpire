<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemesanan - InkSpire</title>
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

        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .step-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #38BDF8;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .step-active {
            background-color: #38BDF8;
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
        }

        .step-inactive {
            color: #adb5bd;
        }

        .step-arrow {
            color: #38BDF8;
        }

        .card-custom {
            border: 2px solid #38BDF8;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-custom .card-header {
            background-color: transparent;
            border-bottom: 1px solid #38BDF8;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            border-color: #38BDF8;
            border-radius: 8px;
        }

        .product-image-placeholder {
            background-color: #e9ecef;
            border-radius: 12px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-4">
        <!-- Breadcrumb Progress -->
        <div class="progress-indicator">
            <span class="step-icon">✓</span>
            <span class="step-active">Pesanan</span>
            <span class="step-arrow">›</span>
            <span class="step-inactive">Pembayaran</span>
        </div>

        <div class="row align-items-start">
            <!-- Kolom Kiri: Detail & Form -->
            <div class="col-md-8">
                <!-- Kartu Detail Pesanan -->
                <div class="card card-custom">
                    <div class="card-header">
                        <i class="bi bi-file-earmark-text-fill" style="color: #38BDF8;"></i>
                        Detail Pesanan
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>No. Pesanan :</strong> {{ $order['no_pesanan'] }}</p>
                        <p class="mb-3"><strong>Tanggal :</strong>
                            {{ \Carbon\Carbon::parse($order['order_date'])->format('d M Y, H:i') }}</p>
                        <hr class="border-secondary opacity-25">
                        <h6 class="fw-bold mb-3 text-secondary">Item Pesanan:</h6>
                        @foreach($order['items'] as $item)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width: 60px; height: 60px; background-color: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;">
                                    @if(!empty($item['produk']['image_produk']))
                                        <img src="{{ route('products.image', $item['produk']['image_produk']) }}" alt="{{ $item['produk']['nama_produk'] ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-image" style="font-size: 1.5rem; color: #38BDF8;"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $item['produk']['nama_produk'] ?? 'Produk ID: ' . $item['id_produk'] }}</h6>
                                    <p class="mb-0 text-muted small">
                                        Harga Satuan: Rp {{ number_format($item['harga_order'] / $item['kuantitas'], 0, ',', '.') }} |
                                        Jumlah: {{ $item['kuantitas'] }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-dark">Rp {{ number_format($item['harga_order'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="border-secondary opacity-10 my-3">
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Kartu Data Pembeli -->
                <div class="card card-custom">
                    <div class="card-header">
                        <i class="bi bi-person-fill" style="color: #38BDF8;"></i>
                        Data Pembeli
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-3 col-form-label font-weight-bold">Email Pembeli</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control bg-light" value="{{ $order['email_pembeli'] }}"
                                    readonly>
                            </div>
                        </div>
                        <p class="text-muted small mb-0"><i class="bi bi-info-circle"></i> Data ini diambil dari akun
                            Anda saat melakukan pemesanan.</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Summary Invoice & Aksi -->
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-header">
                        <i class="bi bi-receipt-cutoff" style="color: #38BDF8;"></i>
                        Ringkasan Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status Pesanan:</span>
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
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Pembayaran:</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($order['total_harga'], 0, ',', '.') }}</span>
                        </div>

                        <hr class="border-secondary opacity-25">

                        <p class="text-muted small mb-4">
                            Terima kasih telah berbelanja di InkSpire. Silakan periksa kembali detail pesanan Anda sebelum melanjutkan.
                        </p>

                        @if ($order['status'] == 'unpaid')
                            <a href="{{ route('payment.create', ['order_id' => $order['id_pesanan']]) }}" class="btn btn-lg w-100"
                                style="background-color: #38BDF8; color: white; border-radius: 30px; padding: 10px 20px; font-size: 1rem; font-weight: bold;">
                                Lanjut Bayar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>