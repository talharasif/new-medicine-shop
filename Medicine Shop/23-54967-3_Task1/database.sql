CREATE DATABASE IF NOT EXISTS OnlineMedicineShop;

USE OnlineMedicineShop;


/* ========================= */
/* CUSTOMER TABLE */
/* ========================= */

CREATE TABLE customer
(
    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,

    password VARCHAR(100) NOT NULL,

    address VARCHAR(255) NOT NULL,

    role VARCHAR(20) NOT NULL
);


/* ========================= */
/* CATEGORY TABLE */
/* ========================= */

CREATE TABLE category
(
    id INT AUTO_INCREMENT PRIMARY KEY,

    category_name VARCHAR(100) NOT NULL
);


/* ========================= */
/* MEDICINE TABLE */
/* ========================= */

CREATE TABLE medicine
(
    id INT AUTO_INCREMENT PRIMARY KEY,

    medicine_name VARCHAR(100) NOT NULL,

    company VARCHAR(100) NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    category_id INT,

    FOREIGN KEY (category_id)
    REFERENCES category(id)
);


/* ========================= */
/* CUSTOMER DATA */
/* ========================= */

INSERT INTO customer
(
    name,
    email,
    password,
    address,
    role
)
VALUES
(
    'Admin',
    'admin@gmail.com',
    '12345678',
    'Dhaka',
    'admin'
),

(
    'Talha',
    'talha@gmail.com',
    '12345678',
    'Dhaka',
    'customer'
);


/* ========================= */
/* CATEGORY DATA */
/* ========================= */

INSERT INTO category
(
    category_name
)
VALUES
('Cold & Flu'),
('Pain Relief'),
('Gastric'),
('Diabetes'),
('Blood Pressure');


/* ========================= */
/* MEDICINE DATA */
/* ========================= */

INSERT INTO medicine
(
    medicine_name,
    company,
    price,
    category_id
)
VALUES
('Napa', 'Beximco', 2.00, 2),

('Paracetamol', 'Square', 2.50, 2),

('Seclo', 'Square', 3.00, 3),

('Oradin', 'Incepta', 4.00, 1),

('Thyvy', 'Square', 5.00, 4),

('Amlopin', 'Square', 3.50, 5),

('DPX', 'Beximco', 4.50, 1),

('Ace', 'Square', 2.00, 2);