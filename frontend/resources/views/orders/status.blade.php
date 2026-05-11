<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan - InkSpire</title>
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

        .card-status {
            border: 2px solid #38BDF8;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .timeline-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .timeline-done {
            background-color: #38BDF8;
            color: white;
        }

        .timeline-pending {
            background-color: #e9ecef;
            color: #adb5bd;
        }

        .product-placeholder {
            background-color: #e9ecef;
            border-radius: 12px;
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-konfirmasi {
            background-color: #38BDF8;
            color: white;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 500;
            border: none;
        }

        .btn-konfirmasi:hover {
            background-color: #0ea5e9;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-4">
        <div class="row align-items-stretch">
            <!-- Kolom Kiri: Status Pesanan -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="card card-status">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Status Pesanan</h5>
                        <hr>
                        <p class="mb-1"><strong>No. Pesanan:</strong> {{ $order['no_pesanan'] }}</p>
                        <p class="mb-3"><strong>Status :</strong> {{ $order['status'] }}</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li class="timeline-item">
                                <span class="timeline-icon timeline-done">✓</span>
                                Pesanan dibuat
                            </li>
                            <li class="timeline-item">
                                @if ($order['status'] == 'unpaid')
                                    <span class="timeline-icon timeline-pending">○</span>
                                @else
                                    <span class="timeline-icon timeline-done">✓</span>
                                @endif
                                Pembayaran dikirim
                            </li>
                            <li class="timeline-item">
                                @if ($order['status'] == 'done')
                                    <span class="timeline-icon timeline-done">✓</span>
                                @else
                                    <span class="timeline-icon timeline-pending">○</span>
                                @endif
                                Selesai
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Tengah + Kanan: Gambar dan Deskripsi -->
            <div class="col-md-8 d-flex flex-column">
                <div class="row flex-grow-1">
                    <div class="col-md-6 d-flex flex-column">
                        <div class="product-placeholder flex-grow-1">
                            <i class="bi bi-image" style="font-size: 4rem; color: #38BDF8;"></i>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="fw-bold">Pesanan #{{ $order['no_pesanan'] }}</h4>
                            <p class="text-muted" style="text-align: justify;">
                                Total: Rp {{ number_format($order['total_harga'], 0, ',', '.') }}<br>
                                Jumlah item: {{ count($order['items'] ?? []) }}<br>
                                Status: {{ $order['status'] }}
                            </p>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-konfirmasi" data-bs-toggle="modal"
                                data-bs-target="#confirmModal">
                                Konfirmasi Status Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Notifikasi Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 text-center">
                <div class="modal-body">
                    <i class="bi bi-bell" style="font-size: 2rem; color: #38BDF8;"></i>
                    <p class="mt-3 mb-4">Pesanan Anda telah selesai.</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary"
                        style="background-color: #38BDF8; border: none; border-radius: 8px; padding: 10px 25px;">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
