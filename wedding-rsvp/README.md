# Wedding RSVP System - Haziq & Haziqah

## 📋 Deskripsi
Sistem RSVP perkahwinan lengkap untuk Haziq & Haziqah pada 20 Disember 2026.

## 🚀 Fitur
- Live countdown ke hari perkahwinan
- Wish feed interaktif
- Track belah keluarga (lelakı & perempuan)
- Gallery pre-wedding & tunang
- Peta interaktif dengan Waze integration
- WhatsApp button langsung
- Admin dashboard
- Responsive design

## 🔧 Instalasi

### 1. Setup Database
```sql
CREATE DATABASE wedding_rsvp;
USE wedding_rsvp;

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