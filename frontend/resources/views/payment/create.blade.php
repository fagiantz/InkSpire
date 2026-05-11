<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - InkSpire</title>
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

        .step-done {
            background-color: #38BDF8;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
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

        .va-number {
            background-color: #38BDF8;
            color: white;
            font-size: 1.5rem;
            padding: 10px 20px;
            border-radius: 12px;
            display: inline-block;
            letter-spacing: 2px;
        }

        .payment-methods .form-check {
            margin-bottom: 10px;
        }

        .payment-methods .form-check-input:checked {
            background-color: #38BDF8;
            border-color: #38BDF8;
        }

        .list-step li {
            margin-bottom: 10px;
        }

        .list-step .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #E6F4FE;
            color: #0D95D2;
            font-weight: 700;
            margin-right: 8px;
            font-size: 0.8rem;
        }

        .btn-bayar {
            background-color: #38BDF8;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-size: 1.1rem;
            border: none;
        }

        .btn-bayar:hover {
            background-color: #0ea5e9;
        }

        .btn-kembali {
            border: 1px solid #38BDF8;
            color: #38BDF8;
            border-radius: 30px;
            padding: 10px 20px;
            background: white;
        }

        .btn-kembali:hover {
            background-color: #f0f9ff;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-4">
        <!-- Breadcrumb Progress -->
        <div class="progress-indicator">
            <span class="step-done">✓</span>
            <a href="{{ route('orders.detail') }}" class="text-muted">Pesanan</a>
            <span class="step-arrow">›</span>
            <span class="step-active">Pembayaran</span>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ringkasan Pembayaran</h5>
                        <div class="border-bottom pb-2 mb-2">
                            <p class="mb-1">No. Pesanan: {{ $order['no_pesanan'] }}</p>
                            <p class="mb-1">Jumlah Item: {{ count($order['items'] ?? []) }}</p>
                        </div>
                        <p class="fw-bold fs-5 mt-2">Total Pembayaran : Rp
                            {{ number_format($order['total_harga'], 0, ',', '.') }}</p>

                        <hr>

                        <h5 class="fw-bold mb-3">Metode Pembayaran</h5>
                        <div class="payment-methods">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bni"
                                    checked>
                                <label class="form-check-label" for="bni">BNI Virtual Account</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bca">
                                <label class="form-check-label" for="bca">BCA Virtual Account</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cc">
                                <label class="form-check-label" for="cc">Kartu Kredit/Debit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="qris">
                                <label class="form-check-label" for="qris">QRIS</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card card-custom">
                    <div class="card-header">
                        <i class="bi bi-file-earmark-text-fill" style="color: #38BDF8;"></i>
                        Panduan Pembayaran
                    </div>
                    <div class="card-body">
                        <ol class="list-unstyled list-step">
                            <li>
                                <span class="step-number">1</span>
                                Buka aplikasi BNI
                            </li>
                            <li>
                                <span class="step-number">2</span>
                                Pilih menu “Bayar” kemudian “Virtual Account”
                            </li>
                            <li>
                                <span class="step-number">3</span>
                                Masukkan Nomor Virtual Account:
                                <div class="text-center mt-2 mb-2">
                                    <div class="va-number">1234 5678 9101 1213</div>
                                </div>
                            </li>
                            <li>
                                <span class="step-number">4</span>
                                Lanjutkan dan konfirmasi pembayaran
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('orders.detail') }}" class="btn btn-kembali">Kembali</a>
                    <button type="button" class="btn btn-bayar" data-bs-toggle="modal"
                        data-bs-target="#successModal">Bayar sekarang</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Notifikasi Sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-body text-center p-5">
                    <p class="mb-1">Pembayaran berhasil.</p>
                    <p class="mb-4">Pesanan Anda sedang diproses.</p>
                    <div class="d-flex justify-content-center mb-4">
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #38BDF8; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-check-lg" style="font-size: 2.5rem; color: #38BDF8;"></i>
                        </div>
                    </div>
                    <a href="{{ route('orders.status') }}" class="btn btn-lg"
                        style="background-color: #38BDF8; color: white; border-radius: 10px; padding: 10px 25px;">Lihat
                        status pesanan</a>
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
