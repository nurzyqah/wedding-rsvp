<?php
// Include configuration
require_once 'config/database.php';

// Get total wishes and recent wishes
$stmt = $pdo->query("SELECT COUNT(*) as total FROM wishes WHERE is_approved = 1");
$totalWishes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get recent wishes
$stmt = $pdo->query("SELECT * FROM wishes WHERE is_approved = 1 ORDER BY created_at DESC LIMIT 10");
$recentWishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="container">
        <div class="main-content">
            <!-- KOLUM KIRI -->
            <div class="left-column">
                <!-- WISH FORM -->
                <section id="wish" class="wish-form-container fade-in">
                    <h3 style="color: var(--dark-blue); font-size: 2.2rem; margin-bottom: 25px;">Hantar Wish untuk Kami</h3>
                    
                    <form id="wishForm" action="api/submit_wish.php" method="POST">
                        <div class="form-group">
                            <label class="form-label">Nama Anda</label>
                            <input type="text" class="form-input" name="name" placeholder="Nama anda..." required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Dari pihak mana?</label>
                            <div class="side-selector">
                                <div class="side-option male active" data-side="male">Pihak Lelaki (Haziq)</div>
                                <div class="side-option female" data-side="female">Pihak Perempuan (Haziqah)</div>
                            </div>
                            <input type="hidden" name="side" id="sideInput" value="male">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Hubungan</label>
                                <select class="form-select" name="relationship">
                                    <option value="family">Keluarga</option>
                                    <option value="relative">Saudara</option>
                                    <option value="friend">Rakan</option>
                                    <option value="colleague">Rakan Sekerja</option>
                                    <option value="neighbor">Jiran</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Status Kehadiran</label>
                                <select class="form-select" name="attendance">
                                    <option value="yes">Akan Hadir</option>
                                    <option value="no">Tidak Dapat Hadir</option>
                                    <option value="maybe">Masih Belum Pasti</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Wish & Doa untuk Pengantin</label>
                            <textarea class="form-textarea" name="message" placeholder="Tuliskan ucapan dan doa anda untuk Haziq & Haziqah..." required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> HANTAR WISH
                        </button>
                    </form>
                </section>
            </div>

            <!-- KOLUM KANAN -->
            <div class="right-column">
                <!-- WISH FEED -->
                <section id="feed" class="wish-feed-container fade-in">
                    <div class="wish-feed-header">
                        <h3 style="color: var(--dark-blue); font-size: 2.2rem;">Wish Terkini</h3>
                        <div class="wish-count" id="wishCounter"><?php echo $totalWishes; ?> wishes</div>
                    </div>
                    
                    <div class="wish-list" id="wishList">
                        <?php foreach ($recentWishes as $wish): ?>
                        <div class="wish-item <?php echo $wish['side'] == 'female' ? 'female-side' : ''; ?>">
                            <div class="wish-header">
                                <div class="wish-author">
                                    <?php echo htmlspecialchars($wish['name']); ?>
                                    <span class="wish-side <?php echo $wish['side']; ?>">
                                        <?php echo $wish['side'] == 'male' ? 'Pihak Lelaki' : 'Pihak Perempuan'; ?>
                                    </span>
                                </div>
                                <div class="wish-time">
                                    <?php 
                                    $time = strtotime($wish['created_at']);
                                    echo date('d M, H:i', $time);
                                    ?>
                                </div>
                            </div>
                            <div class="wish-text"><?php echo htmlspecialchars($wish['message']); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- LOCATION -->
                <section id="location" class="location-container fade-in">
                    <h3 style="color: var(--dark-blue); font-size: 2.2rem; margin-bottom: 25px;">Lokasi</h3>
                    
                    <div class="map-container" id="map"></div>
                    
                    <button class="waze-btn" id="wazeBtn">
                        <i class="fab fa-waze"></i> BUKA DALAM WAZE
                    </button>
                    
                    <div style="background: #f8f8f8; padding: 20px; border-radius: 12px;">
                        <p><strong>MIM Event Hall</strong></p>
                        <p><i class="fas fa-map-pin"></i> Lot 2174, Jalan Khamis, 42200 Klang, Selangor</p>
                        <p><i class="fas fa-clock"></i> Waktu: 10:00 Pagi - 6:00 Petang</p>
                        <p><i class="fas fa-car"></i> Parking: PERCUMA untuk tetamu</p>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- CONTACT SECTION -->
    <div class="container" style="margin: 50px auto;">
        <section id="contact" style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <h3 style="color: var(--dark-blue); font-size: 2.2rem; margin-bottom: 30px;">Hubungi Keluarga Kami</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                <!-- Bapa Pengantin Lelaki -->
                <div style="background: #f9f9f9; padding: 25px; border-radius: 15px; border-left: 5px solid var(--baby-blue);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="width: 60px; height: 60px; background: var(--baby-blue); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="fas fa-male"></i>
                        </div>
                        <div>
                            <h4 style="color: var(--dark-blue); margin-bottom: 5px;">Samsuddin</h4>
                            <p style="color: #777; font-size: 0.9rem;">Bapa Pengantin Lelaki (Haziq)</p>
                        </div>
                    </div>
                    <p style="font-size: 1.2rem; font-weight: 600; color: #333; margin-bottom: 15px;">019-277 6216</p>
                    <button class="whatsapp-btn" data-number="60192776216" style="background: #25D366; color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </button>
                </div>
                
                <!-- Bapa Pengantin Perempuan -->
                <div style="background: #f9f9f9; padding: 25px; border-radius: 15px; border-left: 5px solid var(--dusty-pink);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="width: 60px; height: 60px; background: var(--dusty-pink); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="fas fa-male"></i>
                        </div>
                        <div>
                            <h4 style="color: var(--dark-blue); margin-bottom: 5px;">Norhisham Bin Lasimin</h4>
                            <p style="color: #777; font-size: 0.9rem;">Bapa Pengantin Perempuan (Haziqah)</p>
                        </div>
                    </div>
                    <p style="font-size: 1.2rem; font-weight: 600; color: #333; margin-bottom: 15px;">019-210 0900</p>
                    <button class="whatsapp-btn" data-number="60192100900" style="background: #25D366; color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </button>
                </div>
                
                <!-- Ibu Pengantin Perempuan -->
                <div style="background: #f9f9f9; padding: 25px; border-radius: 15px; border-left: 5px solid var(--dusty-pink);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="width: 60px; height: 60px; background: var(--dusty-pink); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="fas fa-female"></i>
                        </div>
                        <div>
                            <h4 style="color: var(--dark-blue); margin-bottom: 5px;">Siti Fadzlina</h4>
                            <p style="color: #777; font-size: 0.9rem;">Ibu Pengantin Perempuan (Haziqah)</p>
                        </div>
                    </div>
                    <p style="font-size: 1.2rem; font-weight: 600; color: #333; margin-bottom: 15px;">019-332 9569</p>
                    <button class="whatsapp-btn" data-number="60193329569" style="background: #25D366; color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </button>
                </div>
            </div>
        </section>
    </div>

<?php include 'includes/footer.php'; ?>