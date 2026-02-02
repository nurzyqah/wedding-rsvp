<?php
// Database configuration - using SQLite for local development
$dbFile = __DIR__ . '/../database/wedding_rsvp.db';

// Create database directory if it doesn't exist
$dbDir = dirname($dbFile);
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0755, true);
}

// Create connection
try {
    $pdo = new PDO("sqlite:" . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Create tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS wishes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            side TEXT NOT NULL,
            relationship TEXT,
            attendance TEXT,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            ip_address TEXT,
            is_approved INTEGER DEFAULT 1
        )
    ");
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
?>
