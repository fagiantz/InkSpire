<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - InkSpire</title>
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

        /* Styling sidebar */
        .sidebar {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper .form-control {
            border-color: #38BDF8;
            border-radius: 20px;
            padding-right: 40px;
        }

        .search-wrapper .search-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #333;
            font-size: 1.2rem;
        }

        .search-divider {
            height: 1px;
            background-color: #38BDF8;
            margin: 15px 0;
        }

        /* Kategori radio */
        .category-item {
            margin-bottom: 8px;
        }

        .category-item .form-check-input {
            border-color: #38BDF8;
            background-color: white;
        }

        .category-item .form-check-input:checked {
            background-color: #38BDF8;
            border-color: #38BDF8;
        }

        .category-item .form-check-label {
            font-weight: 500;
        }

        /* Product card */
        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            transition: 0.2s;
            background: white;
        }

        .product-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            background-color: #e9ecef;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .product-desc {
            color: #6c757d;
            font-size: 0.875rem;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="sidebar">
                    <h3 class="fw-bold mb-4">Katalog</h3>

                    <form action="{{ route('katalog') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="search-wrapper">
                            <input type="text" name="query" class="form-control" placeholder="Cari"
                                value="{{ request('query') }}">
                            <button type="submit" class="search-icon"
                                style="background: none; border: none; padding: 0; outline: none;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="search-divider"></div>

                        <!-- Kategori filter -->
                        <div class="mb-3 fw-bold">Kategori</div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="" type="radio" name="cat" id="catAll"
                                onchange="this.form.submit()" {{ !request()->has('cat') || request('cat') == '' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catAll">Semua</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="banner" type="radio" name="cat" id="catBanner"
                                onchange="this.form.submit()" {{ request('cat') == 'banner' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catBanner">Banner</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="mug" type="radio" name="cat" id="catMug"
                                onchange="this.form.submit()" {{ request('cat') == 'mug' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catMug">Custom Mug</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="keychain" type="radio" name="cat" id="catKeychain"
                                onchange="this.form.submit()" {{ request('cat') == 'keychain' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catKeychain">Keychain</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="sticker" type="radio" name="cat" id="catStiker"
                                onchange="this.form.submit()" {{ request('cat') == 'sticker' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catStiker">Stiker</label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9">
                <div class="row g-4">
                    @forelse ($produks as $produk)
                        <div class="col-6 col-lg-4">
                            <a href="{{ route('produk.detail', $produk['id_produk']) }}" class="text-decoration-none">
                                <div class="product-card">
                                    <div class="product-img"
                                        style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; overflow: hidden;">
                                        @if(!empty($produk['image_produk']))
                                            <img src="{{ route('products.image', $produk['image_produk']) }}"
                                                alt="{{ $produk['nama_produk'] }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-image" style="font-size: 3rem; color: #38BDF8;"></i>
                                        @endif
                                    </div>
                                    <div class="product-info">
                                        <h6 class="product-title">{{ $produk['nama_produk'] }}</h6>
                                        <span class="badge mb-2"
                                            style="background-color: #0D95D2;">{{ ucfirst($produk['kategori'] ?? '') }}</span>
                                        <p class="product-desc text-primary fw-bold mb-0">Rp
                                            {{ number_format($produk['harga'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada produk tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
    @include("partials.footer")
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>