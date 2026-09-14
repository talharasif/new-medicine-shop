-- =========================================================
-- ONLINE MEDICINE SHOP - CLEAN COMPATIBLE DATABASE
-- WARNING: This recreates the database from scratch.
-- =========================================================

DROP DATABASE IF EXISTS online_medicine_shop;

CREATE DATABASE online_medicine_shop
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE online_medicine_shop;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
    address TEXT NULL,
    phone VARCHAR(30) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category_type ENUM('liquid','solid') NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_categories_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE medicines (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    category_id INT NOT NULL,
    vendor_name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    availability INT NOT NULL DEFAULT 0,
    description TEXT NULL,
    image_path VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_medicines_category (category_id),
    CONSTRAINT fk_medicines_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cart (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY unique_cart_item (user_id, medicine_id),
    KEY idx_cart_medicine (medicine_id),
    CONSTRAINT fk_cart_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_cart_medicine
        FOREIGN KEY (medicine_id)
        REFERENCES medicines(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    shipping_address TEXT NOT NULL,
    status ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
    order_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_orders_user (user_id),
    KEY idx_orders_status (status),
    CONSTRAINT fk_orders_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE order_items (
    id INT NOT NULL AUTO_INCREMENT,
    order_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id),
    KEY idx_order_items_order (order_id),
    KEY idx_order_items_medicine (medicine_id),
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_order_items_medicine
        FOREIGN KEY (medicine_id)
        REFERENCES medicines(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- SAMPLE DATA
-- =========================================================

INSERT INTO users (name, email, password_hash, role, address, phone) VALUES
('Admin Demo', 'admin@example.com', 'demo_password_not_used_in_task2', 'admin', 'Dhaka', '01700000000'),
('Customer One', 'customer1@example.com', 'demo_customer_password', 'customer', 'Dhaka', '01800000001'),
('Customer Two', 'customer2@example.com', 'demo_customer_password', 'customer', 'Chattogram', '01900000002');

INSERT INTO categories (name, category_type) VALUES
('Tablets', 'solid'),
('Capsules', 'solid'),
('Syrups', 'liquid'),
('Drops', 'liquid');

INSERT INTO medicines
(name, category_id, vendor_name, price, availability, description, image_path)
VALUES
('Napa 500mg', 1, 'Beximco Pharma', 2.50, 100, 'Paracetamol tablet for pain and fever.', NULL),
('Seclo 20mg', 2, 'Square Pharmaceuticals', 7.50, 80, 'Capsule for gastric acidity.', NULL),
('Napa Syrup', 3, 'Beximco Pharma', 45.00, 40, 'Liquid paracetamol syrup.', NULL),
('Eye Drop Demo', 4, 'Demo Vendor', 90.00, 25, 'Sample liquid medicine for testing.', NULL);

INSERT INTO cart (user_id, medicine_id, quantity) VALUES
(2, 1, 2),
(3, 3, 1);

INSERT INTO orders (user_id, total_amount, shipping_address, status) VALUES
(2, 40.00, 'House 10, Road 5, Dhaka', 'pending'),
(3, 90.00, 'Agrabad, Chattogram', 'accepted'),
(2, 15.00, 'House 10, Road 5, Dhaka', 'rejected');

INSERT INTO order_items (order_id, medicine_id, quantity, unit_price) VALUES
(1, 1, 10, 2.50),
(1, 2, 2, 7.50),
(2, 4, 1, 90.00),
(3, 2, 2, 7.50);
