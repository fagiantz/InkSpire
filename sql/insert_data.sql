INSERT INTO User (email, password, role, name, created_at) VALUES
('user1@example.com', 'pass1', 'customer', 'Andi Wijaya', '2024-01-01 10:00:00'),
('user2@example.com', 'pass2', 'customer', 'Budi Santoso', '2024-01-02 11:00:00'),
('user3@example.com', 'pass3', 'admin', 'Citra Dewi', '2024-01-03 12:00:00'),
('user4@example.com', 'pass4', 'customer', 'Dian Permata', '2024-01-04 13:00:00'),
('user5@example.com', 'pass5', 'customer', 'Eka Pratama', '2024-01-05 14:00:00'),
('user6@example.com', 'pass6', 'admin', 'Fajar Nugroho', '2024-01-06 15:00:00'),
('user7@example.com', 'pass7', 'customer', 'Gina Lestari', '2024-01-07 16:00:00'),
('user8@example.com', 'pass8', 'customer', 'Hadi Susanto', '2024-01-08 17:00:00'),
('user9@example.com', 'pass9', 'customer', 'Indah Sari', '2024-01-09 18:00:00'),
('user10@example.com', 'pass10', 'customer', 'Joko Widodo', '2024-01-10 19:00:00');

INSERT INTO Produk (nama_produk, harga) VALUES
('Laptop Asus', 7500000),
('Mouse Logitech', 150000),
('Keyboard Mechanical', 450000),
('Monitor Samsung 24"', 1800000),
('Webcam HD', 350000),
('Headset Gaming', 600000),
('SSD 512GB', 850000),
('RAM 8GB DDR4', 550000),
('Speaker Bluetooth', 400000),
('USB Flashdisk 32GB', 120000);

INSERT INTO `Order` (email, total_harga, status, order_date) VALUES
('user1@example.com', 7650000, 'completed', '2024-02-01 08:30:00'),
('user2@example.com', 150000, 'pending', '2024-02-02 09:15:00'),
('user3@example.com', 450000, 'shipped', '2024-02-03 10:45:00'),
('user4@example.com', 1800000, 'completed', '2024-02-04 11:20:00'),
('user5@example.com', 350000, 'cancelled', '2024-02-05 12:10:00'),
('user6@example.com', 600000, 'completed', '2024-02-06 13:40:00'),
('user7@example.com', 850000, 'pending', '2024-02-07 14:55:00'),
('user8@example.com', 550000, 'shipped', '2024-02-08 15:30:00'),
('user9@example.com', 400000, 'completed', '2024-02-09 16:20:00'),
('user10@example.com', 120000, 'pending', '2024-02-10 17:00:00');

INSERT INTO OrderItem (id_pesanan, id_produk, kuantitas, hargaOrder) VALUES
(1, 1, 1, 7500000),   
(1, 2, 1, 150000),    
(2, 2, 1, 150000),   
(3, 3, 1, 450000),    
(4, 4, 1, 1800000),   
(5, 5, 1, 350000),   
(6, 6, 1, 600000),    
(7, 7, 1, 850000),    
(8, 8, 1, 550000),    
(9, 9, 1, 400000);    