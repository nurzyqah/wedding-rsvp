-- Buat database
CREATE DATABASE wedding_rsvp;

-- Gunakan database
USE wedding_rsvp;

-- Table untuk wishes
CREATE TABLE wishes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    side ENUM('male', 'female') NOT NULL,
    relationship VARCHAR(50),
    attendance VARCHAR(20),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    is_approved BOOLEAN DEFAULT 1
);

-- Table untuk gallery
CREATE TABLE gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(50),
    image_url VARCHAR(255),
    caption VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table untuk counters
CREATE TABLE counters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wish_count INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO wishes (name, side, relationship, attendance, message) VALUES
('Keluarga Samsuddin', 'male', 'family', 'yes', 'Tahniah Haziq! Semoga Allah kurniakan keberkatan dalam rumah tangga.'),
('Keluarga Norhisham', 'female', 'family', 'yes', 'Alhamdulillah anakanda Haziqah. Doa ayah dan ibu.'),
('Amin', 'male', 'friend', 'yes', 'Congrats bro! Semoga berbahagia selalu!');