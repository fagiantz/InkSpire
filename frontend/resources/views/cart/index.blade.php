<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - InkSpire</title>
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

        .custom-alert {
            background-color: #DCFCE7;
            color: #15803D;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .custom-alert-danger {
            background-color: #FEE2E2;
            color: #B91C1C;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .cart-card-custom {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 24px 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.03);
            border: none;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 20px;
            position: relative;
        }

        .product-image-container {
            width: 120px;
            height: 120px;
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
            content: "120 × 120";
            position: absolute;
            color: #94A3B8;
            font-size: 0.8rem;
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

        .btn-delete-topright {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: #94A3B8;
            font-size: 1.2rem;
            padding: 0;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .btn-delete-topright:hover {
            color: #EF4444;
        }

        .product-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 8px;
        }

        .cart-meta-text {
            font-size: 0.9rem;
            color: #64748B;
            margin-bottom: 6px;
        }

        .qty-input-custom {
            width: 60px;
            height: 30px;
            text-align: center;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #0F172A;
            background-color: #F8FAFC;
        }

        .cart-price-right {
            font-size: 1.15rem;
            font-weight: 700;
            color: #2563EB;
            white-space: nowrap;
        }

        .checkout-card-custom {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.03);
            border: none;
        }

        .checkout-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 24px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .summary-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1E293B;
        }

        .summary-value {
            font-size: 1rem;
            font-weight: 700;
            color: #0F172A;
        }

        .btn-checkout-custom {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 12px 36px;
            font-size: 0.95rem;
            font-weight: 700;
            transition: all 0.2s ease;
            text-decoration: none;
            display: block;
            margin: 32px auto 0 auto;
            width: fit-content;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-checkout-custom:hover:not(:disabled) {
            background-color: #1D4ED8;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            transform: translateY(-1px);
        }

        .btn-checkout-custom:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-checkout-custom:disabled {
            background-color: #94A3B8;
            box-shadow: none;
            cursor: not-allowed;
            opacity: 0.65;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <div class="container-fluid py-4 px-4">
        <h2 class="fw-bold mb-4">Keranjang Saya</h2>

        <div class="row">
            <!-- Items in Cart -->
            <div class="col-md-8">
                @if (session('success'))
                    <div class="custom-alert">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="custom-alert-danger">{{ session('error') }}</div>
                @endif

                @php $totalPrice = 0; @endphp
                @forelse ($cart as $id => $item)
                    @php $totalPrice += $item['harga'] * $item['kuantitas']; @endphp
                    <div class="cart-card-custom flex-column flex-md-row">

                        <!-- Form Hapus di Pojok Kanan Atas -->
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $id }}">
                            <button type="submit" class="btn-delete-topright" title="Hapus produk">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>

                        <!-- Gambar Produk -->
                        <div class="product-image-container">
                            @if(!empty($item['image_produk']))
                                <img src="{{ route('products.image', $item['image_produk']) }}"
                                    alt="{{ $item['nama_produk'] }}">
                            @endif
                        </div>

                        <!-- Detail Produk -->
                        <div class="flex-grow-1 text-center text-md-start">
                            <h5 class="product-name">{{ $item['nama_produk'] }}</h5>
                            <p class="cart-meta-text">Harga Satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            <p class="cart-meta-text">Jumlah: {{ $item['kuantitas'] }}</p>
                        </div>

                        <!-- Harga Total Item -->
                        <div class="text-center text-md-end mt-3 mt-md-0 pe-md-4">
                            <p class="cart-price-right mb-0">Rp
                                {{ number_format($item['harga'] * $item['kuantitas'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                        <p class="mt-3 text-muted">Keranjang belanja Anda masih kosong.</p>
                        <a href="{{ route('katalog') }}" class="btn-checkout-custom px-4 py-2 mt-2 d-inline-block">Mulai
                            Belanja</a>
                    </div>
                @endforelse
            </div>

            <!-- Checkout Summary -->
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="checkout-card-custom">
                    <h5 class="checkout-title">Ringkasan Belanja</h5>

                    <div class="summary-row">
                        <span class="summary-label text-muted">Total Harga</span>
                        <span class="summary-value">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <hr />
                    <div class="summary-row mb-4">
                        <span class="summary-label">Total Bayar</span>
                        <span class="summary-value text-primary fs-5">Rp
                            {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    @if(count($cart) > 0)
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-checkout-custom w-100">
                                Beli Sekarang
                            </button>
                        </form>
                    @else
                        <button class="btn-checkout-custom w-100" disabled>
                            Beli Sekarang
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>