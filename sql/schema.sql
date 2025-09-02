CREATE DATABASE IF NOT EXISTS library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_db;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  borrowed_count INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(150) NOT NULL,
  total_copies INT NOT NULL DEFAULT 1,
  available_copies INT NOT NULL DEFAULT 1,
  daily_late_fee DECIMAL(8,2) DEFAULT 0.50,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS borrows (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  borrowed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  due_date DATETIME NOT NULL,
  returned_at DATETIME DEFAULT NULL,
  late_fee DECIMAL(8,2) DEFAULT 0.00,
  status ENUM('borrowed','returned') DEFAULT 'borrowed',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (name, email) VALUES
('Ahmed Ali', 'ahmed@example.com'),
('Fatima Saeed', 'fatima@example.com');

INSERT INTO books (title, author, total_copies, available_copies, daily_late_fee) VALUES
('Clean Code', 'Robert C. Martin', 3, 3, 1.00),
('PHP Objects, Patterns, and Practice', 'M. Zandstra', 2, 2, 0.75),
('Design Patterns', 'Erich Gamma', 1, 1, 1.50);
