<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk['nama_produk'] }} - InkSpire</title>
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

        .product-image {
            background-color: #e9ecef;
            border-radius: 12px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-back {
            background-color: #38BDF8;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
        }

        .btn-back:hover {
            background-color: #0ea5e9;
        }
    </style>
</head>

<body>
    @include('partials.header')
    <main class="container py-4">
        <a href="{{ route('katalog') }}" class="btn btn-back mb-3"><i class="bi bi-arrow-left"></i> Kembali ke
            Katalog</a>
        <div class="row">
            <div class="col-md-5">
                <div class="product-image">
                    <i class="bi bi-image" style="font-size: 5rem; color: #38BDF8;"></i>
                </div>
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold">{{ $produk['nama_produk'] }}</h2>
                <p class="text-muted">Produk berkualitas tinggi dari InkSpire.</p>
                <h4 class="fw-bold text-primary">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</h4>
                <div class="mt-4">
                    <a href="{{ route('order.create', $produk['id_produk']) }}" class="btn btn-lg"
                        style="background-color: #38BDF8; color: white; border-radius: 30px; padding: 10px 30px;">
                        <i class="bi bi-cart-plus"></i> Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </main>
    <footer class="text-center text-muted py-4"><small>&copy; 2025 InkSpire. All rights reserved.</small></footer>
</body>

</html>
