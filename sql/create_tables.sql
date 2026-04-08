CREATE TABLE User (
    email VARCHAR(100) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `Order` (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    total_harga DOUBLE NOT NULL,
    status VARCHAR(50) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (email) REFERENCES User(email) ON DELETE CASCADE
);

CREATE TABLE Produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    harga DOUBLE NOT NULL
);

CREATE TABLE OrderItem (
    id_order_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    id_produk INT NOT NULL,
    kuantitas INT NOT NULL,
    hargaOrder DOUBLE NOT NULL,
    FOREIGN KEY (id_pesanan) REFERENCES `Order`(id_pesanan) ON DELETE CASCADE,
    FOREIGN KEY (id_produk) REFERENCES Produk(id_produk)
);