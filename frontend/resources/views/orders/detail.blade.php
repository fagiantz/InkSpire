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

        <div class="row align-items-stretch"> <!-- Kolom Kiri: Ringkasan & Form -->
            <div class="col-md-7">
                <!-- Kartu Detail Pesanan -->
                <div class="card card-custom">
                    <div class="card-header">
                        <i class="bi bi-file-earmark-text-fill" style="color: #38BDF8;"></i>
                        Detail Pesanan
                    </div>
                    <div class="card-body">
                        <p><strong>No. Pesanan :</strong> {{ $order['no_pesanan'] }}</p>
                        <p><strong>Tanggal :</strong>
                            {{ \Carbon\Carbon::parse($order['order_date'])->format('d M Y, H:i') }}</p>
                        <hr>
                        <h6 class="fw-bold mb-3">Item Pesanan:</h6>
                        @foreach($order['items'] as $item)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Produk :</strong>
                                    {{ $item['produk']['nama_produk'] ?? 'Produk ID: ' . $item['id_produk'] }}</p>
                                <p class="mb-1"><strong>Harga Satuan :</strong> Rp
                                    {{ number_format($item['harga_order'] / $item['kuantitas'], 0, ',', '.') }}
                                </p>
                                <p class="mb-1"><strong>Jumlah :</strong> {{ $item['kuantitas'] }}</p>
                                <p class="mb-0"><strong>Subtotal :</strong> Rp
                                    {{ number_format($item['harga_order'], 0, ',', '.') }}
                                </p>
                                @if(!$loop->last)
                                <hr class="border-secondary opacity-25"> @endif
                            </div>
                        @endforeach
                        <hr>
                        <h5 class="fw-bold text-primary">Total : Rp
                            {{ number_format($order['total_harga'], 0, ',', '.') }}
                        </h5>
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

            <!-- Kolom Kanan: Preview Produk -->
            <div class="col-md-5 d-flex flex-column">
                <div class="product-image-placeholder flex-grow-1 d-flex align-items-center justify-content-center">
                    <i class="bi bi-image" style="font-size: 4rem; color: #38BDF8;"></i>
                </div>
                <h4 class="fw-bold mt-3">{{ $order['items'][0]['produk']['nama_produk'] ?? 'Detail Pesanan' }}</h4>
                <p class="text-muted flex-shrink-0">
                    Terima kasih telah berbelanja di InkSpire. Pesanan Anda dengan nomor
                    <strong>{{ $order['no_pesanan'] }}</strong> sedang kami proses.
                    Pastikan data pesanan di samping sudah benar sebelum melanjutkan ke tahap pembayaran.
                </p>
            </div>
        </div>

        <!-- Tombol Lanjut Bayar -->
        @if ($order['status'] != 'process')
            <div class="text-end mt-4">
                <a href="{{ route('payment.create') }}" class="btn btn-lg"
                    style="background-color: #38BDF8; color: white; border-radius: 30px; padding: 10px 30px;">
                    Lanjut Bayar
                </a>
            </div>
        @endif
    </main>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>