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

        .btn-upload {
            background-color: #38BDF8;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-size: 1.1rem;
            border: none;
        }

        .btn-upload:hover {
            background-color: #0ea5e9;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-4">
        <!-- Breadcrumb Progress -->
        <div class="progress-indicator">
            <span class="step-done">✓</span>
            <a href="{{ route('orders.detail', $order['id_pesanan']) }}" class="text-muted">Pesanan</a>
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
                            {{ number_format($order['total_harga'], 0, ',', '.') }}
                        </p>

                        <hr>

                        <h5 class="fw-bold mb-3">Upload Bukti Pembayaran</h5>
                        <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order['id_pesanan'] }}">

                            <div class="mb-3">
                                <label for="receipt" class="form-label fw-semibold">Pilih File Bukti Pembayaran</label>
                                <input type="file" class="form-control" id="receipt" name="receipt"
                                    accept="image/jpeg,image/png,image/jpg" required style="border-color: #38BDF8;">
                                <div class="form-text">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-upload">
                                    <i class="bi bi-cloud-upload-fill"></i> Upload & Selesaikan Pembayaran
                                </button>
                            </div>
                        </form>
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
                        <div class="mb-4 p-3 bg-light rounded" style="border-left: 4px solid #38BDF8;">
                            <h6 class="fw-bold mb-2" style="color: #0D95D2;">Rekening Tujuan Transfer:</h6>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-primary px-2 py-1">BANK MANDIRI</span>
                                <strong class="fs-6">123-4567-890-12</strong>
                            </div>
                            <p class="mb-0 text-muted small">Atas Nama: <strong>PT InkSpire Indonesia</strong></p>
                        </div>
                        <ol class="list-unstyled list-step">
                            <li>
                                <span class="step-number">1.</span>
                                Lakukan transfer ke rekening tujuan
                            </li>
                            <li>
                                <span class="step-number">2.</span>
                                Screenshot atau simpan bukti transfer
                            </li>
                            <li>
                                <span class="step-number">3.</span>
                                Upload bukti transfer melalui form di samping
                            </li>
                            <li>
                                <span class="step-number">4.</span>
                                Admin akan memverifikasi pembayaran Anda
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>
</body>

</html>