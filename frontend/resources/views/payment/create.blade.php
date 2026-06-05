<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F7FC;
            color: #1E293B;
            margin: 0;
        }

        .progress-indicator-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .step-pill-completed {
            background-color: #EBF3FF;
            color: #2563EB;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .step-pill-active {
            background-color: #2563EB;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .step-arrow-custom {
            color: #94A3B8;
            font-weight: bold;
            font-size: 1rem;
        }

        .card-custom {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.05);
            border: none;
            margin-bottom: 24px;
        }

        .card-title-custom {
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 24px;
            color: #2563EB;
        }

        .card-subtitle-custom {
            font-weight: 800;
            font-size: 1.15rem;
            margin-top: 28px;
            margin-bottom: 16px;
            color: #1E293B;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.95rem;
            color: #475569;
        }

        .summary-row-highlight {
            background-color: #F8FAFC;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .summary-label-highlight {
            font-size: 0.95rem;
            font-weight: 600;
            color: #475569;
        }

        .summary-value-highlight {
            font-size: 1.25rem;
            font-weight: 800;
            color: #2563EB;
        }

        /* Upload drag/drop zone styling */
        .upload-dropzone {
            border: 2px dashed #CBD5E1;
            border-radius: 16px;
            padding: 36px 20px;
            text-align: center;
            background-color: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .upload-dropzone:hover {
            border-color: #2563EB;
            background-color: #F8FAFC;
        }

        .upload-icon {
            font-size: 1.8rem;
            color: #2563EB;
            background-color: #EBF3FF;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .upload-text {
            font-weight: 600;
            font-size: 0.95rem;
            color: #0F172A;
            margin: 0;
        }

        .upload-subtext {
            font-size: 0.8rem;
            color: #64748B;
            margin: 0;
        }

        .upload-file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .btn-pay-custom {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 14px 36px;
            font-size: 0.95rem;
            font-weight: 700;
            transition: all 0.2s ease, transform 0.1s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-pay-custom:hover {
            background-color: #1D4ED8;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            transform: translateY(-1px);
        }

        .btn-pay-custom:active {
            transform: translateY(0);
        }

        /* Payment Guide Destination Info Box */
        .bank-transfer-box {
            border-left: 4px solid #2563EB;
            background-color: #F8FAFC;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .bank-badge {
            background-color: #2563EB;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 14px;
        }

        .transfer-label {
            font-size: 0.85rem;
            color: #64748B;
            margin-bottom: 4px;
        }

        .account-number-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .account-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: 0.5px;
        }

        .btn-copy-custom {
            background-color: #EBF3FF;
            color: #2563EB;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }

        .btn-copy-custom:hover {
            background-color: #2563EB;
            color: #ffffff;
        }

        .account-owner {
            font-size: 0.9rem;
            color: #475569;
            margin-bottom: 0;
        }

        /* Step List Styling */
        .step-list-item {
            background-color: #F8FAFC;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .step-number-circle {
            background-color: #2563EB;
            color: #ffffff;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 0.9rem;
            color: #1E293B;
            margin-bottom: 0;
            font-weight: 500;
        }
    </style>
</head>

<body>
    @include('partials.header')

    @php
        $totalItems = 0;
        if (isset($order['items'])) {
            foreach ($order['items'] as $item) {
                $totalItems += $item['kuantitas'] ?? 1;
            }
        }
    @endphp

    <main class="container pt-4 pb-2">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('orders.detail', $order['id_pesanan']) }}" class="btn btn-secondary px-3"
                style="border-radius: 50px;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Breadcrumb Progress -->
        <div class="progress-indicator-custom">
            <a href="{{ route('orders.detail', $order['id_pesanan']) }}" class="step-pill-completed">
                <i class="bi bi-check-lg"></i> Detail Pesanan
            </a>
            <span class="step-arrow-custom">›</span>
            <span class="step-pill-active">Pembayaran</span>
        </div>

        <div class="row">
            <!-- Kolom Kiri: Ringkasan & Form Upload -->
            <div class="col-md-7">
                <div class="card-custom">
                    <h5 class="card-title-custom">Ringkasan Pembayaran</h5>

                    <div class="summary-row">
                        <span>No. Pesanan</span>
                        <strong class="text-dark">{{ $order['no_pesanan'] }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Jumlah Item</span>
                        <strong class="text-dark">{{ $totalItems }} Item</strong>
                    </div>

                    <div class="summary-row-highlight">
                        <span class="summary-label-highlight">Total Pembayaran</span>
                        <span class="summary-value-highlight">Rp
                            {{ number_format($order['total_harga'], 0, ',', '.') }}</span>
                    </div>

                    <h5 class="card-subtitle-custom">Upload Bukti Pembayaran</h5>

                    <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order['id_pesanan'] }}">

                        <div class="upload-dropzone" id="dropzone">
                            <div class="upload-icon">
                                <i class="bi bi-cloud-upload-fill" id="upload-icon-inner"></i>
                            </div>
                            <p class="upload-text" id="upload-text-label">Pilih File Bukti Pembayaran</p>
                            <p class="upload-subtext" id="upload-subtext-label">Format: JPG, JPEG, PNG. Maksimal 2MB.
                            </p>
                            <input type="file" class="upload-file-input" id="receipt" name="receipt"
                                accept="image/jpeg,image/png,image/jpg" required>
                        </div>

                        <button type="submit" class="btn-pay-custom w-100">
                            <i class="bi bi-cloud-arrow-up-fill"></i> Upload & Selesaikan Pembayaran
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kolom Kanan: Panduan Pembayaran -->
            <div class="col-md-5">
                <div class="card-custom">
                    <h5 class="card-title-custom">Panduan Pembayaran</h5>

                    <div class="bank-transfer-box">
                        <span class="bank-badge">BANK MANDIRI</span>
                        <div class="transfer-label">Rekening Tujuan Transfer:</div>
                        <div class="account-number-wrapper">
                            <span class="account-number" id="account-no">123-4567-890-12</span>
                            <button type="button" class="btn-copy-custom"
                                onclick="copyToClipboard('123-4567-890-12', this)">
                                <i class="bi bi-copy"></i> Salin
                            </button>
                        </div>
                        <p class="account-owner">Atas Nama: <strong>PT InkSpire Indonesia</strong></p>
                    </div>

                    <div class="step-list-item">
                        <div class="step-number-circle">1</div>
                        <p class="step-text">Lakukan transfer ke rekening tujuan</p>
                    </div>

                    <div class="step-list-item">
                        <div class="step-number-circle">2</div>
                        <p class="step-text">Screenshot atau simpan bukti transfer</p>
                    </div>

                    <div class="step-list-item">
                        <div class="step-number-circle">3</div>
                        <p class="step-text">Upload bukti transfer melalui form di samping</p>
                    </div>

                    <div class="step-list-item">
                        <div class="step-number-circle">4</div>
                        <p class="step-text">Admin akan memverifikasi pembayaran Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include("partials.footer")

    <script>
        document.getElementById('receipt').addEventListener('change', function (e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "Pilih File Bukti Pembayaran";
            const fileLabel = document.getElementById('upload-text-label');
            const subLabel = document.getElementById('upload-subtext-label');
            const iconInner = document.getElementById('upload-icon-inner');
            const dropzone = document.getElementById('dropzone');

            if (e.target.files[0]) {
                fileLabel.textContent = fileName;
                subLabel.textContent = "Klik lagi jika ingin mengganti file.";
                iconInner.className = "bi bi-check-circle-fill text-success";
                dropzone.style.borderColor = "#2563EB";
            } else {
                fileLabel.textContent = "Pilih File Bukti Pembayaran";
                subLabel.textContent = "Format: JPG, JPEG, PNG. Maksimal 2MB.";
                iconInner.className = "bi bi-cloud-upload-fill";
                dropzone.style.borderColor = "#CBD5E1";
            }
        });

        function copyToClipboard(text, btnElement) {
            navigator.clipboard.writeText(text).then(function () {
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="bi bi-check-lg"></i> Berhasil';
                btnElement.classList.add('bg-success', 'text-white');
                setTimeout(function () {
                    btnElement.innerHTML = originalHtml;
                    btnElement.classList.remove('bg-success', 'text-white');
                }, 2000);
            }).catch(function (err) {
                console.error('Gagal menyalin text: ', err);
            });
        }
    </script>
</body>

</html>