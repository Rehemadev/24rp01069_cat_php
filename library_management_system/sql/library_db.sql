-- Database: library_db
CREATE DATABASE IF NOT EXISTS library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_db;

-- Users table with roles
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','student') NOT NULL DEFAULT 'student',
  student_id VARCHAR(50) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Books
CREATE TABLE IF NOT EXISTS books (
  book_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  status ENUM('Available','Borrowed') NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB;

-- Borrowed books
CREATE TABLE IF NOT EXISTS borrowed_books (
  borrow_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(50) NOT NULL,
  book_id INT NOT NULL,
  borrow_date DATETIME NOT NULL,
  return_date DATETIME NULL,
  CONSTRAINT fk_borrow_book FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Seed admin
INSERT INTO users (username,email,password,role) VALUES
('admin','admin@example.com', '$2y$10$1q7Q1Txx4n2I0sJx6z3VYO1m3oLQnUe0V6p7v7g0y3A6X9d0o0dSe', 'admin'); -- password: Admin@123

-- Sample books
INSERT INTO books (title,author,category,status) VALUES
('Clean Code','Robert C. Martin','Software','Available'),
('The Pragmatic Programmer','Andrew Hunt','Software','Available'),
('Introduction to Algorithms','Cormen et al.','CS','Available');
