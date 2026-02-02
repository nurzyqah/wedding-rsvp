<?php
session_start();
// Dapatkan jumlah wishes jika $pdo tersedia
$totalWishes = 0;
if (isset($pdo)) {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM wishes WHERE is_approved = 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalWishes = $result['total'];
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAZIQ & HAZIQAH | 20.12.2026</title>
    
    <!-- CSS & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Custom CSS -->
    <style>
        :root {
            --baby-blue: #89CFF0;
            --dusty-pink: #DCB6B6;
            --soft-blue: #B5D8EB;
            --light-pink: #F5D6D6;
            --gold: #D4AF37;
            --dark-blue: #2C5F8B;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f9f7ff 0%, #f0f8ff 100%);
            color: #333;
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* HEADER */
        .header {
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url('https://images.unsplash.com/photo-1511988617509-a57c8a288659?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 60px 20px 40px;
            position: relative;
            overflow: hidden;
        }
        
        .monogram {
            font-family: 'Great Vibes', cursive;
            font-size: 5rem;
            color: var(--dark-blue);
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .couple-names {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--dark-blue);
            margin-bottom: 20px;
            letter-spacing: 2px;
        }
        
        .wedding-date {
            font-size: 1.5rem;
            color: var(--dusty-pink);
            font-weight: 500;
            margin-bottom: 40px;
        }
        
        .countdown-container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            padding: 30px;
            display: inline-block;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 2px solid var(--baby-blue);
            margin-bottom: 40px;
        }
        
        .countdown-title {
            color: var(--dark-blue);
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 25px;
        }
        
        .countdown-item {
            text-align: center;
            min-width: 80px;
        }
        
        .countdown-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            background: var(--baby-blue);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 5px;
            box-shadow: 0 5px 15px rgba(137, 207, 240, 0.3);
        }
        
        .countdown-label {
            font-size: 0.9rem;
            color: var(--dark-blue);
            font-weight: 500;
        }
        
        /* NAVIGATION */
        .nav-container {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-menu {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 15px 0;
        }
        
        .nav-item {
            margin: 0 25px;
        }
        
        .nav-link {
            text-decoration: none;
            color: var(--dark-blue);
            font-weight: 500;
            font-size: 1.1rem;
            padding: 8px 20px;
            border-radius: 30px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-link:hover, .nav-link.active {
            background: var(--baby-blue);
            color: white;
        }
        
        /* MAIN CONTENT - 2 KOLUM */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin: 50px auto;
        }
        
        /* WISH FORM */
        .wish-form-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 8px solid var(--dark-blue);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-blue);
            font-weight: 500;
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: border 0.3s;
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--baby-blue);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .side-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .side-option {
            flex: 1;
            text-align: center;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .side-option.active {
            border-color: var(--baby-blue);
            background: rgba(137, 207, 240, 0.1);
            color: var(--dark-blue);
        }
        
        .side-option.male.active {
            border-color: var(--baby-blue);
            background: rgba(137, 207, 240, 0.2);
        }
        
        .side-option.female.active {
            border-color: var(--dusty-pink);
            background: rgba(220, 182, 182, 0.2);
        }
        
        .submit-btn {
            background: linear-gradient(to right, var(--baby-blue), var(--dark-blue));
            color: white;
            border: none;
            padding: 18px 40px;
            font-size: 1.1rem;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(44, 95, 139, 0.3);
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(44, 95, 139, 0.4);
        }
        
        /* WISH FEED */
        .wish-feed-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: 500px;
            display: flex;
            flex-direction: column;
        }
        
        .wish-feed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .wish-count {
            background: var(--baby-blue);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .wish-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 10px;
        }
        
        .wish-item {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--baby-blue);
            position: relative;
        }
        
        .wish-item.female-side {
            border-left-color: var(--dusty-pink);
        }
        
        .wish-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .wish-author {
            font-weight: 600;
            color: var(--dark-blue);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .wish-side {
            font-size: 0.8rem;
            padding: 3px 10px;
            border-radius: 10px;
            margin-left: 10px;
        }
        
        .wish-side.male {
            background: rgba(137, 207, 240, 0.3);
            color: var(--dark-blue);
        }
        
        .wish-side.female {
            background: rgba(220, 182, 182, 0.3);
            color: #8B5A5A;
        }
        
        .wish-time {
            font-size: 0.85rem;
            color: #888;
        }
        
        .wish-text {
            color: #555;
            line-height: 1.6;
        }
        
        /* LOCATION */
        .map-container {
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 25px;
            border: 3px solid var(--baby-blue);
        }
        
        .waze-btn {
            background: #33CCFF;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 auto 25px;
            transition: all 0.3s;
        }
        
        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .couple-names {
                font-size: 2.8rem;
            }
            
            .monogram {
                font-size: 4rem;
            }
        }
        
        @media (max-width: 768px) {
            .nav-menu {
                flex-wrap: wrap;
            }
            
            .nav-item {
                margin: 5px 10px;
            }
            
            .countdown {
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .countdown-item {
                min-width: 70px;
            }
            
            .countdown-number {
                font-size: 2rem;
                padding: 10px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        /* FLOWER DECORATION */
        .flower {
            position: absolute;
            font-size: 1.5rem;
            color: var(--dusty-pink);
            opacity: 0.7;
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="flower flower-1">🌸</div>
        <div class="flower flower-2">💮</div>
        
        <div class="container">
            <h1 class="monogram">HH</h1>
            <h2 class="couple-names">HAZIQ & HAZIQAH</h2>
            <p class="wedding-date">20 DECEMBER 2026 | MIM EVENT HALL, KLANG</p>
            
            <div class="countdown-container">
                <div class="countdown-title">Countdown to Our Special Day</div>
                <div class="countdown">
                    <div class="countdown-item">
                        <div class="countdown-number" id="days">000</div>
                        <div class="countdown-label">HARI</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="hours">00</div>
                        <div class="countdown-label">JAM</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="minutes">00</div>
                        <div class="countdown-label">MINIT</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="seconds">00</div>
                        <div class="countdown-label">SAAT</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- NAVIGATION -->
    <div class="nav-container">
        <nav>
            <ul class="nav-menu">
                <li class="nav-item"><a href="#gallery" class="nav-link active"><i class="fas fa-images"></i> Gallery</a></li>
                <li class="nav-item"><a href="#wish" class="nav-link"><i class="fas fa-heart"></i> Hantar Wish</a></li>
                <li class="nav-item"><a href="#feed" class="nav-link"><i class="fas fa-comments"></i> Wish Feed</a></li>
                <li class="nav-item"><a href="#location" class="nav-link"><i class="fas fa-map-marker-alt"></i> Lokasi</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link"><i class="fas fa-phone-alt"></i> Hubungi</a></li>
            </ul>
        </nav>
    </div>