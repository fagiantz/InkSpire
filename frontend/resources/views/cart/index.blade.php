<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - InkSpire</title>
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

        .main-content {
            background-color: #F8F9FA;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .cart-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .product-placeholder {
            background-color: #e9ecef;
            border-radius: 12px;
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkout-box {
            background: white;
            border: 2px solid #38BDF8;
            border-radius: 12px;
            padding: 20px;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <div class="container py-5">
        <h2 class="fw-bold mb-4">Keranjang Saya</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <!-- Items in Cart -->
            <div class="col-md-8">
                @php $totalPrice = 0; @endphp
                @forelse ($cart as $id => $item)
                    @php $totalPrice += $item['harga'] * $item['kuantitas']; @endphp
                    <div class="cart-card d-flex flex-column flex-md-row align-items-md-center gap-3 position-relative">
                        <form action="{{ route('cart.remove') }}" method="POST" class="position-absolute" style="top: 15px; right: 15px;">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $id }}">
                            <button type="submit" class="btn btn-link text-danger p-0 border-0" title="Hapus produk">
                                <i class="bi bi-trash-fill fs-5"></i>
                            </button>
                        </form>

                        <div class="product-placeholder">
                            <i class="bi bi-image" style="font-size: 2.5rem; color: #38BDF8;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">{{ $item['nama_produk'] }}</h5>
                            <p class="text-muted mb-1">Harga Satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            <p class="mb-0 fw-semibold">Jumlah: {{ $item['kuantitas'] }}</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0 pe-md-4">
                            <p class="fw-bold fs-5 text-primary mb-0">Rp {{ number_format($item['harga'] * $item['kuantitas'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 main-content">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                        <p class="mt-3 fs-5">Keranjang belanja Anda masih kosong.</p>
                        <a href="{{ route('katalog') }}" class="btn btn-primary btn-lg mt-2"
                            style="background-color: #38BDF8; border: none; border-radius: 30px;">Mulai Belanja</a>
                    </div>
                @endforelse
            </div>

            <!-- Checkout Summary -->
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="checkout-box shadow-sm">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga</span>
                        <span class="fw-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Bayar</span>
                        <span class="fw-bold fs-5 text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    
                    @if(count($cart) > 0)
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-lg w-100" style="background-color: #38BDF8; color: white; border-radius: 30px;">
                                Beli Sekarang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-lg w-100 btn-secondary" style="border-radius: 30px;" disabled>
                            Beli Sekarang
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted py-4 mt-5">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>
</body>

</html>
