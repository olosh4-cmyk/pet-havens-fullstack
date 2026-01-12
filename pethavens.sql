-- -----------------------------------------------------
-- Database: pethavens_db
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS pethavens_db;
USE pethavens_db;

-- -----------------------------------------------------
-- Table: users
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Insert 10 sample user records
-- (You can keep these as examples or modify names/emails)
-- -----------------------------------------------------
INSERT INTO users (first_name, last_name, username, email, password)
VALUES
('Emily', 'Johnson', 'emjay', 'emily@example.com', 'hashed_password_1'),
('Michael', 'Brown', 'mikeb', 'michael@example.com', 'hashed_password_2'),
('Sophia', 'Davis', 'sophiad', 'sophia@example.com', 'hashed_password_3'),
('James', 'Wilson', 'jaywil', 'james@example.com', 'hashed_password_4'),
('Olivia', 'Moore', 'livmoore', 'olivia@example.com', 'hashed_password_5'),
('Daniel', 'Taylor', 'dantay', 'daniel@example.com', 'hashed_password_6'),
('Ava', 'Anderson', 'avanda', 'ava@example.com', 'hashed_password_7'),
('Ethan', 'Thomas', 'ethant', 'ethan@example.com', 'hashed_password_8'),
('Isabella', 'Martin', 'isam', 'isabella@example.com', 'hashed_password_9'),
('Noah', 'Garcia', 'noahg', 'noah@example.com', 'hashed_password_10');
