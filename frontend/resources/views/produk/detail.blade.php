<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk['nama_produk'] }} - InkSpire</title>
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

        .btn-back-custom {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
            margin-bottom: 22px;
        }

        .btn-back-custom:hover {
            background-color: #1D4ED8;
        }

        .btn-back-custom:active {
            transform: scale(0.97);
        }

        .product-image-card {
            background-color: #E0ECFC;
            border-radius: 20px;
            height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.03);
            border: none;
            position: relative;
        }

        .product-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-text-centered {
            color: #ffffff;
            font-size: 2.25rem;
            font-weight: 700;
            text-align: center;
            padding: 20px;
            opacity: 0.9;
            text-shadow: 0 2px 10px rgba(13, 70, 183, 0.15);
        }

        .product-title-detail {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .product-desc-detail {
            color: #64748B;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .product-price-detail {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2563EB;
            margin-bottom: 28px;
        }

        .btn-qty {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s ease, transform 0.1s ease;
            cursor: pointer;
        }

        .btn-qty:hover {
            background-color: #1D4ED8;
        }

        .btn-qty:active {
            transform: scale(0.95);
        }

        .qty-input {
            width: 50px;
            height: 32px;
            text-align: center;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #0F172A;
            outline: none;
            background-color: #ffffff;
        }

        /* Prevent numeric input spinner wheels */
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn-add-cart-custom {
            background-color: #2563EB;
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 12px 32px;
            font-size: 0.95rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            transition: all 0.2s ease, transform 0.1s ease;
            text-decoration: none;
        }

        .btn-add-cart-custom:hover {
            background-color: #1D4ED8;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            transform: translateY(-1px);
        }

        .btn-add-cart-custom:active {
            transform: translateY(0);
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-4">
        <!-- Back Button -->
        <a href="{{ route('katalog') }}" class="btn-back-custom">
            ← Kembali ke Katalog
        </a>

        <div class="row">
            <!-- Left Column: Product Image -->
            <div class="col-md-6 col-lg-5 mb-4 mb-md-0">
                <div class="product-image-card">
                    @if(!empty($produk['image_produk']))
                        <img src="{{ route('products.image', $produk['image_produk']) }}"
                            alt="{{ $produk['nama_produk'] }}">
                    @else
                        <div class="placeholder-text-centered">{{ $produk['nama_produk'] }}</div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Product Detail Block -->
            <div class="col-md-6 col-lg-7">
                <h1 class="product-title-detail">{{ $produk['nama_produk'] }}</h1>
                <p class="product-desc-detail">
                    {{ $produk['deskripsi'] ?? 'Produk premium berkualitas tinggi siap dicetak sesuai desain Anda.' }}
                </p>

                <h4 class="product-price-detail">
                    Rp {{ number_format($produk['harga'], 0, ',', '.') }}
                </h4>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk['id_produk'] }}">

                    <!-- Quantity Selection -->
                    <div class="d-flex align-items-center mb-4 gap-2">
                        <span class="fw-semibold me-2" style="font-size: 0.95rem; color: #1E293B;">Jumlah:</span>
                        <button type="button" class="btn-qty" onclick="changeQty(-1)">-</button>
                        <input type="number" name="kuantitas" id="kuantitas" value="1" min="1"
                            class="qty-input text-center" readonly>
                        <button type="button" class="btn-qty" onclick="changeQty(1)">+</button>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-add-cart-custom">
                        <i class="bi bi-cart-fill"></i> Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </main>

    @include("partials.footer")

    <script>
        function changeQty(amount) {
            const input = document.getElementById('kuantitas');
            let val = parseInt(input.value) + amount;
            if (val < 1) val = 1;
            input.value = val;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>