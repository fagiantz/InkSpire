<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemesanan - InkSpire</title>
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

        .step-pill-active {
            background-color: #2563EB;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .step-pill-inactive {
            background-color: #ffffff;
            color: #1E293B;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.02);
        }

        .step-arrow-custom {
            color: #475569;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .card-custom {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
            border: none;
            margin-bottom: 24px;
        }

        .card-title-custom {
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 24px;
        }

        .text-primary-custom {
            color: #2563EB;
        }

        .product-image-container {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background-color: #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        .product-image-container::after {
            content: "80 × 80";
            position: absolute;
            color: #94A3B8;
            font-size: 0.75rem;
            font-weight: 500;
            z-index: 1;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 2;
        }

        .product-name-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
        }

        .meta-text-custom {
            font-size: 0.875rem;
            color: #64748B;
            margin-bottom: 0;
        }

        .price-text-custom {
            font-size: 1rem;
            font-weight: 700;
            color: #2563EB;
            white-space: nowrap;
        }

        .form-label-custom {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            display: block;
        }

        .form-control-custom {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #0F172A;
            background-color: #ffffff;
            width: 100%;
            outline: none;
        }

        .form-subtext {
            font-size: 0.8rem;
            color: #94A3B8;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .status-badge-custom {
            display: inline-block;
            font-size: 0.8rem;
            padding: 6px 16px;
            font-weight: 600;
            border-radius: 50px;
            margin-bottom: 20px;
        }

        .summary-label-detail {
            font-size: 0.875rem;
            color: #64748B;
            margin-bottom: 4px;
        }

        .summary-value-detail {
            font-size: 1.4rem;
            font-weight: 800;
            color: #2563EB;
            margin-bottom: 20px;
        }

        .summary-desc {
            font-size: 0.875rem;
            color: #64748B;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .btn-pay-custom {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 12px 36px;
            font-size: 0.95rem;
            font-weight: 700;
            transition: all 0.2s ease, transform 0.1s ease;
            text-decoration: none;
            display: block;
            margin: 28px auto 0 auto;
            width: fit-content;
            text-align: center;
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
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container pt-4 pb-2">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary px-3" style="border-radius: 50px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Breadcrumb Progress -->
        <div class="progress-indicator-custom">
            <span class="step-pill-active">Detail Pesanan</span>
            @if ($order['status'] == 'unpaid')
                <span class="step-arrow-custom">›</span>
                <span class="step-pill-inactive">Pembayaran</span>
            @endif
        </div>

        <div class="row align-items-start">
            <!-- Kolom Kiri: Detail & Form -->
            <div class="col-md-8">
                <!-- Kartu Detail Pesanan -->
                <div class="card-custom">
                    <h5 class="card-title-custom text-primary-custom">Detail Pesanan</h5>

                    <p class="mb-2" style="font-size: 0.95rem;">
                        <i class="bi bi-bag"></i>
                        <strong>No. Pesanan :</strong>
                        {{ $order['no_pesanan'] }}
                    </p>
                    <p class="mb-4" style="font-size: 0.95rem;">
                        <i class="bi bi-calendar3"></i>
                        <strong>Tanggal :</strong>
                        <span class="local-datetime"
                            data-utc="{{ \Carbon\Carbon::parse($order['order_date'])->toIso8601String() }}">
                            {{ \Carbon\Carbon::parse($order['order_date'])->format('d M Y, H:i') }}
                        </span>
                    </p>

                    <hr class="border-secondary opacity-10 mb-4">

                    <h6 class="fw-bold mb-3 text-secondary"
                        style="font-size: 0.9rem; letter-spacing: 0.5px; text-transform: uppercase;">Item Pesanan:</h6>

                    @foreach($order['items'] as $item)
                        @php
                            $unitPrice = $item['kuantitas'] > 0 ? ($item['harga_order'] / $item['kuantitas']) : $item['harga_order'];
                            $formattedUnitPrice = number_format($unitPrice, 0, ',', '.');
                            $formattedItemHarga = number_format($item['harga_order'], 0, ',', '.');
                        @endphp
                        <div class="d-flex align-items-center gap-3 py-2">
                            <!-- Gambar Placeholder -->
                            <div class="product-image-container">
                                @if(!empty($item['produk']['image_produk']))
                                    <img src="{{ route('products.image', $item['produk']['image_produk']) }}"
                                        alt="{{ $item['produk']['nama_produk'] ?? '' }}">
                                @endif
                            </div>

                            <!-- Detail Info -->
                            <div class="flex-grow-1">
                                <h6 class="product-name-title">
                                    {{ $item['produk']['nama_produk'] ?? 'Produk ID: ' . $item['id_produk'] }}
                                </h6>
                                <p class="meta-text-custom">
                                    Harga Satuan: Rp {{ $formattedUnitPrice }} | Jumlah: {{ $item['kuantitas'] }}
                                </p>
                            </div>

                            <!-- Total Item Price -->
                            <div class="text-end">
                                <span class="price-text-custom">Rp {{ $formattedItemHarga }}</span>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr class="border-secondary opacity-5 my-3">
                        @endif
                    @endforeach
                </div>

                <!-- Kartu Data Pembeli -->
                <div class="card-custom">
                    <h5 class="card-title-custom">Data Pembeli</h5>
                    <div class="mb-3">
                        <label class="form-label-custom">Email Pembeli</label>
                        <input type="text" class="form-control-custom" value="{{ $order['email_pembeli'] }}" readonly>
                        <p class="form-subtext">Data ini diambil dari akun Anda saat melakukan pemesanan.</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Summary Invoice & Aksi -->
            <div class="col-md-4">
                <div class="card-custom">
                    <h5 class="card-title-custom text-primary-custom">Ringkasan Pembayaran</h5>

                    @php
                        $badgeStyle = match ($order['status']) {
                            'unpaid' => 'background-color: #F59E0B; color: #ffffff;',
                            'paid' => 'background-color: #2563EB; color: #ffffff;',
                            'process' => 'background-color: #0D95D2; color: #ffffff;',
                            'done' => 'background-color: #10B981; color: #ffffff;',
                            default => 'background-color: #64748B; color: #ffffff;',
                        };
                        $statusText = match ($order['status']) {
                            'unpaid' => 'Belum dibayar',
                            'paid' => 'Sudah dibayar',
                            'process' => 'Diproses',
                            'done' => 'Selesai',
                            default => $order['status'],
                        };
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="summary-label-detail mb-0">Status Pesanan:</span>
                        <span class="status-badge-custom mb-0" style="{{ $badgeStyle }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <div class="summary-label-detail">Total Pembayaran:</div>
                    <div class="summary-value-detail">
                        Rp {{ number_format($order['total_harga'], 0, ',', '.') }}
                    </div>

                    <p class="summary-desc">
                        Terima kasih telah berbelanja di InkSpire. Silakan periksa kembali detail pesanan Anda sebelum
                        melanjutkan.
                    </p>

                    @if ($order['status'] == 'unpaid')
                        <a href="{{ route('payment.create', ['order_id' => $order['id_pesanan']]) }}"
                            class="btn-pay-custom w-100">
                            Lanjut Bayar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </main>

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
                    el.textContent = `${day} ${month} ${year}, ${hour}:${minute}`;
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>