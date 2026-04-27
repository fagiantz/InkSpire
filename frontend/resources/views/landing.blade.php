<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InkSpire</title>
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

        .card-product {
            transition: 0.2s;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card-product:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Sembunyikan scrollbar galeri */
        #galleryContainer::-webkit-scrollbar {
            display: none;
        }

        #galleryContainer {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <!-- Hero : Populer -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Populer</h2>
            <div class="row align-items-center">
                <!-- Kolom kiri: 1 gambar besar -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <div
                        style="background-color: #e9ecef; border-radius: 12px; height: 240px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-image" style="font-size: 4rem; color: #38BDF8;"></i>
                    </div>
                </div>
                <!-- Kolom tengah: teks Lorem Ipsum -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="card-title">Lorem Ipsum</h5>
                    <p class="text-muted" style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Donec erat dui, luctus vel semper in, ultricies varius massa. Aliquam erat
                        volutpat. Curabitur vehicula tortor sapien, lobortis varius enim pulvinar sit amet. Curabitur at
                        neque iaculis, dictum nulla at, dignissim elit. Sed efficitur euismod dapibus. Nullam enim sem,
                        sodales scelerisque elit sed, fringilla viverra ex. Fusce elit mi, porta sit amet molestie
                        lacinia, condimentum vitae velit.</p>
                </div>
                <!-- Kolom kanan: 4 gambar grid 2x2 -->
                <div class="col-md-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <div
                                style="background-color: #e9ecef; border-radius: 12px; height: 115px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image" style="font-size: 2rem; color: #38BDF8;"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                style="background-color: #e9ecef; border-radius: 12px; height: 115px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image" style="font-size: 2rem; color: #38BDF8;"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                style="background-color: #e9ecef; border-radius: 12px; height: 115px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image" style="font-size: 2rem; color: #38BDF8;"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                style="background-color: #e9ecef; border-radius: 12px; height: 115px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image" style="font-size: 2rem; color: #38BDF8;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori Scrollable dengan tombol -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Kategori</h2>
            <div class="d-flex align-items-center">
                <!-- Tombol kiri -->
                <button id="scrollLeft" class="btn btn-light rounded-circle shadow-sm me-2"
                    style="width: 40px; height: 40px; min-width: 40px;">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <!-- Area scroll, hanya 5 gambar terlihat -->
                <div id="galleryContainer" class="flex-grow-1"
                    style="overflow-x: auto; white-space: nowrap; display: flex; gap: 15px; padding-bottom: 10px; scroll-behavior: smooth; max-width: 2000px;">
                    @for ($i = 1; $i <= 10; $i++)
                        <div
                            style="flex: 0 0 225px; height: 225px; background-color: #e9ecef; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 2.5rem; color: #38BDF8;"></i>
                        </div>
                    @endfor
                </div>

                <!-- Tombol kanan -->
                <button id="scrollRight" class="btn btn-light rounded-circle shadow-sm ms-2"
                    style="width: 40px; height: 40px; min-width: 40px;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <!-- Tombol Lihat Semua di tengah -->
            <div class="text-center mt-4">
                <a href="{{ route('katalog') }}" class="btn"
                    style="background-color: #38BDF8; color: white; border-radius: 20px; padding: 10px 25px;">Lihat
                    Semua</a>
            </div>
        </div>
    </section>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('galleryContainer');
            const btnLeft = document.getElementById('scrollLeft');
            const btnRight = document.getElementById('scrollRight');
            const scrollAmount = 195; // lebar item 180 + gap 15

            btnLeft.addEventListener('click', () => {
                container.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            btnRight.addEventListener('click', () => {
                container.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
