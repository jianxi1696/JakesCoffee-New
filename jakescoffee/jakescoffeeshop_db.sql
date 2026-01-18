DROP DATABASE IF EXISTS coffeeshop_db;
CREATE DATABASE coffeeshop_db;
USE coffee_shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer','admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO categories (name)
VALUES ('Starbucks');


CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    image_file_name VARCHAR(255) NOT NULL,
    archived TINYINT(1) DEFAULT 0
);


INSERT INTO product (product_name, product_price, image_file_name, archived)
VALUES
('Affogato', 180.00, 'affogato.jpg', 0)
('Americano', 150.00, 'americano.jpg', 0),
('Cappuccino', 165.00, 'cappuccino.jpg', 0),
('Coffee', 140.00, 'coffee.jpg', 0),
('Cold Brew', 170.00, 'cold_brew.jpg', 0),
('Cortado', 160.00, 'cortado.jpg', 0),
('Espresso', 130.00, 'espresso.jpg', 0),
('Flat White', 165.00, 'flat_white.jpg', 0),
('Java Chip', 190.00, 'java_chip.jpg', 0),
('Latte', 160.00, 'latte.jpg', 0),
('Macchiato', 170.00, 'macchiato.jpg', 0),
('Mocha', 175.00, 'mocha.jpg', 0),
('Vanilla Latte', 180.00, 'vanilla_latte.jpg',0);


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','paid','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE music (
    music_id INT AUTO_INCREMENT PRIMARY KEY,
    music_title VARCHAR(255) NOT NULL,
    music_file_name VARCHAR(255) NOT NULL,
    archived TINYINT(1) DEFAULT 0
);
