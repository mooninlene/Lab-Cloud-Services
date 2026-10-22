CREATE TABLE IF NOT EXISTS custom_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    menu_item VARCHAR(100) NOT NULL,
    sweetness_level VARCHAR(50) DEFAULT 'Normal',
    sauce_preference VARCHAR(50) DEFAULT 'Normal',
    status ENUM('Preparing', 'Served') DEFAULT 'Preparing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Memasukkan contoh orderan menggunakan menu asli
INSERT INTO custom_orders (customer_name, menu_item, sweetness_level, sauce_preference) VALUES 
('Meja 1', 'Es Kopi Susu Tedja', '30% (Slightly Sweet)', 'Normal'),
('Meja 2', 'Nasi Kulit Lada Garam', 'Normal', 'Extra Pedas/Sambal'),
('Meja 3', 'Coco Matcha', 'Less Sugar', 'Normal');