<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Produk - InkSpire</title>
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

        .sidebar {
            background-color: #fff;
            border-right: 2px solid #38BDF8;
            min-height: calc(100vh - 56px);
            padding: 30px 20px;
        }

        .sidebar .nav-link {
            color: #6c757d;
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link.active {
            background-color: #E6F4FE;
            color: #0D95D2;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
        }

        .main-content {
            background-color: #F8F9FA;
            padding: 30px;
        }

        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .btn-tambah {
            background-color: #38BDF8;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
            border: none;
        }

        .btn-edit {
            background-color: #38BDF8;
            color: white;
            border-radius: 8px;
            padding: 5px 15px;
            border: none;
            font-size: 0.9rem;
        }

        .btn-hapus {
            background-color: #dc3545;
            color: white;
            border-radius: 8px;
            padding: 5px 15px;
            border: none;
            font-size: 0.9rem;
        }

        .btn-edit:hover,
        .btn-tambah:hover {
            background-color: #0ea5e9;
        }

        .btn-hapus:hover {
            background-color: #bb2d3b;
        }

        /* Modal */
        .custom-dropdown {
            position: relative;
            width: 100%;
        }

        .custom-dropdown-toggle {
            background-color: white;
            border: 2px solid #38BDF8;
            border-radius: 8px;
            padding: 8px 15px;
            width: 100%;
            text-align: left;
            position: relative;
            cursor: pointer;
        }

        .custom-dropdown-toggle i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0D95D2;
            transition: transform 0.2s;
        }

        .custom-dropdown-toggle.open i {
            transform: translateY(-50%) rotate(180deg);
        }

        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #38BDF8;
            border-top: none;
            border-radius: 0 0 8px 8px;
            display: none;
            z-index: 1000;
        }

        .custom-dropdown-menu.show {
            display: block;
        }

        .custom-dropdown-item {
            padding: 8px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .custom-dropdown-item:last-child {
            border-bottom: none;
        }

        .custom-dropdown-item:hover {
            background-color: #F0F9FF;
        }

        .custom-dropdown-item.active {
            background-color: #E6F4FE;
            color: #0D95D2;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <!-- Header Admin -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white fw-bold mb-0" href="#">InkSpire</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm"
                    style="background-color: white; color: #0D95D2; border-radius: 20px;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders') }}">
                            <i class="bi bi-cart-fill"></i>
                            Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.produk.index') }}">
                            <i class="bi bi-box-seam"></i>
                            Produk
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">PRODUK</h2>
                    <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Tambah Produk
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-card">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $produk)
                                    <tr>
                                        <td>{{ $produk['id_produk'] }}</td>
                                        <td>{{ $produk['nama_produk'] }}</td>
                                        <td>Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                                        <td>
                                            <button class="btn btn-edit btn-sm me-1" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit" data-id="{{ $produk['id_produk'] }}"
                                                data-nama="{{ $produk['nama_produk'] }}"
                                                data-harga="{{ $produk['harga'] }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.produk.destroy', $produk['id_produk']) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-hapus btn-sm">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="bi bi-inbox display-4 text-muted"></i>
                                            <p class="mt-2 mb-0">Belum ada produk.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-4">
                    <h4 class="fw-bold mb-3">Tambah Produk</h4>
                    <form method="POST" action="{{ route('admin.produk.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required min="0">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-tambah">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-4">
                    <h4 class="fw-bold mb-3">Edit Produk</h4>
                    <form id="formEdit" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" id="editNama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" id="editHarga" class="form-control" required
                                min="0">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-edit">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Saat modal edit dibuka, isi form dengan data produk
        var modalEdit = document.getElementById('modalEdit');
        modalEdit.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var harga = button.getAttribute('data-harga');

            document.getElementById('editNama').value = nama;
            document.getElementById('editHarga').value = harga;

            // Set action form ke route update
            var form = document.getElementById('formEdit');
            form.action = '/admin/produk/' + id;
        });
    </script>
</body>

</html>
