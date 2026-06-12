-- TRMS Database Schema
-- MySQL 8.0+ compatible

CREATE DATABASE IF NOT EXISTS trms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE trms_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','manager','user') DEFAULT 'user',
    avatar VARCHAR(500) NULL,
    bio TEXT NULL,
    phone VARCHAR(50) NULL,
    department VARCHAR(255) NULL,
    joined DATE NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    venue VARCHAR(255) NOT NULL,
    type ENUM('concert', 'class', 'rehearsal', 'recital', 'meeting', 'workshop') DEFAULT 'concert',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Activities table
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(255) NOT NULL,
    time VARCHAR(100) NOT NULL,
    icon VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stats table
CREATE TABLE IF NOT EXISTS stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    value VARCHAR(100) NOT NULL,
    icon VARCHAR(100) NOT NULL,
    change VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: password123)
INSERT INTO users (name, email, password, role, avatar, bio, phone, department, joined)
VALUES (
    'Maestro Alexander',
    'alexander@trms.edu',
    '$2y$12$9Igw7nXFNzTZyzTr/3lvTuvX1JZxB4ml2MpshXmHn0nTba5TzsQVy',
    'admin',
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    'Classical pianist and conductor with 20+ years of experience in music education.',
    '+1 (555) 123-4567',
    'Orchestra & Piano',
    '2018-09-01'
) ON DUPLICATE KEY UPDATE name = name;

-- Insert seed events
INSERT INTO events (title, date, time, venue, type) VALUES
('Spring Concert', '2026-06-15', '19:00:00', 'Grand Hall', 'concert'),
('Piano Masterclass', '2026-06-18', '14:00:00', 'Studio A', 'class'),
('Orchestra Rehearsal', '2026-06-20', '10:00:00', 'Rehearsal Room', 'rehearsal'),
('Student Recital', '2026-06-22', '16:00:00', 'Concert Hall', 'recital'),
('Faculty Meeting', '2026-06-25', '09:00:00', 'Conference Room', 'meeting'),
('Violin Workshop', '2026-06-28', '13:00:00', 'Studio B', 'workshop')
ON DUPLICATE KEY UPDATE title = title;

-- Insert seed activities
INSERT INTO activities (text, time, icon) VALUES
('New student enrolled in Piano Advanced', '2 hours ago', 'bi-person-plus'),
('Spring Concert venue confirmed', '4 hours ago', 'bi-check-circle'),
('Monthly faculty report submitted', '6 hours ago', 'bi-file-earmark-text'),
('New instrument donation received', '1 day ago', 'bi-gift'),
('Summer camp registration opened', '1 day ago', 'bi-sun')
ON DUPLICATE KEY UPDATE text = text;

-- Insert seed stats
INSERT INTO stats (label, value, icon, change) VALUES
('Total Students', '248', 'bi-people', '+12%'),
('Upcoming Events', '6', 'bi-calendar-event', '+2'),
('Active Courses', '18', 'bi-book', '+3'),
('Revenue', '$42.5k', 'bi-cash-stack', '+8%')
ON DUPLICATE KEY UPDATE label = label;
