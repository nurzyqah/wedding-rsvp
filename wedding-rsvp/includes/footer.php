    <!-- FOOTER -->
    <footer style="background: var(--dark-blue); color: white; text-align: center; padding: 40px 20px; margin-top: 80px;">
        <div class="container">
            <p style="font-size: 1.1rem; margin-bottom: 10px;">Terima kasih atas doa dan restu anda semua</p>
            <p style="font-size: 1.1rem; margin-bottom: 10px;">20 Disember 2026 | Mim Event Hall, Klang</p>
            <p style="color: var(--baby-blue); font-weight: 600; font-size: 1.2rem; letter-spacing: 1px; margin-top: 20px;">#HaziqHaziqah2026</p>
            <p style="margin-top: 20px; color: #aaa;">
                <i class="fas fa-heart" style="color: #ff6b6b;"></i> 
                Dibuat dengan penuh kasih sayang untuk tetamu kami yang dikasihi
            </p>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // ==================== COUNTDOWN ====================
        function initCountdown() {
            const weddingDate = new Date('December 20, 2026 10:00:00').getTime();
            
            function updateCountdown() {
                const now = new Date().getTime();
                const timeLeft = weddingDate - now;
                
                if (timeLeft > 0) {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                    
                    document.getElementById('days').textContent = days.toString().padStart(3, '0');
                    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
                } else {
                    document.getElementById('days').textContent = "000";
                    document.getElementById('hours').textContent = "00";
                    document.getElementById('minutes').textContent = "00";
                    document.getElementById('seconds').textContent = "00";
                }
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // ==================== MAP ====================
        function initMap() {
            // Koordinat MIM Event Hall, Klang
            const mimEventHall = [3.0367, 101.4455];
            
            const map = L.map('map').setView(mimEventHall, 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Custom wedding marker
            const weddingIcon = L.divIcon({
                html: '<i class="fas fa-heart" style="color: #e63946; font-size: 30px;"></i>',
                iconSize: [40, 40],
                className: 'wedding-marker'
            });
            
            L.marker(mimEventHall, { icon: weddingIcon })
                .addTo(map)
                .bindPopup('<b>MIM Event Hall</b><br>Lot 2174, Jalan Khamis, 42200 Klang, Selangor')
                .openPopup();
        }

        // ==================== WISH FORM HANDLING ====================
        document.addEventListener('DOMContentLoaded', function() {
            initCountdown();
            
            // Initialize map if element exists
            if (document.getElementById('map')) {
                initMap();
            }
            
            // Side selector
            document.querySelectorAll('.side-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.side-option').forEach(opt => {
                        opt.classList.remove('active');
                    });
                    
                    this.classList.add('active');
                    document.getElementById('sideInput').value = this.getAttribute('data-side');
                });
            });
            
            // Waze button
            if (document.getElementById('wazeBtn')) {
                document.getElementById('wazeBtn').addEventListener('click', function() {
                    const wazeURL = `https://waze.com/ul?ll=3.0367,101.4455&navigate=yes&zoom=17`;
                    window.open(wazeURL, '_blank');
                });
            }
            
            // WhatsApp buttons
            document.querySelectorAll('.whatsapp-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const number = this.getAttribute('data-number');
                    const message = `Assalamualaikum, saya ingin bertanya tentang majlis perkahwinan Haziq & Haziqah pada 20 Disember 2026.`;
                    const whatsappURL = `https://wa.me/${number}?text=${encodeURIComponent(message)}`;
                    
                    window.open(whatsappURL, '_blank');
                });
            });
            
            // Form submission dengan AJAX
            const wishForm = document.getElementById('wishForm');
            if (wishForm) {
                wishForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch('api/submit_wish.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Terima kasih! Wish anda telah berjaya dihantar.');
                            location.reload(); // Reload untuk papar wish baru
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Sila cuba lagi.');
                    });
                });
            }
            
            // Smooth scrolling untuk navigation
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    document.querySelectorAll('.nav-link').forEach(l => {
                        l.classList.remove('active');
                    });
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Scroll to section
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);
                    
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add random flowers untuk decoration
            function addFlowers() {
                const flowerContainer = document.querySelector('.header');
                if (!flowerContainer) return;
                
                const flowerEmojis = ['🌸', '💮', '🏵️', '🌺', '🌼', '🌻'];
                
                for (let i = 0; i < 8; i++) {
                    const flower = document.createElement('div');
                    flower.className = `flower flower-${i+1}`;
                    flower.textContent = flowerEmojis[Math.floor(Math.random() * flowerEmojis.length)];
                    flower.style.top = `${Math.random() * 90 + 5}%`;
                    flower.style.left = `${Math.random() * 90 + 5}%`;
                    flower.style.fontSize = `${Math.random() * 1.5 + 1}rem`;
                    flower.style.opacity = `${Math.random() * 0.5 + 0.3}`;
                    flowerContainer.appendChild(flower);
                }
            }
            
            addFlowers();
            
            // Resize header when scrolling
            window.addEventListener('scroll', function() {
                const header = document.querySelector('.header');
                if (!header) return;
                
                const scrolled = window.pageYOffset;
                
                if (scrolled > 100) {
                    header.style.padding = '30px 20px 20px';
                    const coupleNames = header.querySelector('.couple-names');
                    const monogram = header.querySelector('.monogram');
                    if (coupleNames) coupleNames.style.fontSize = '2.5rem';
                    if (monogram) monogram.style.fontSize = '3.5rem';
                } else {
                    header.style.padding = '60px 20px 40px';
                    const coupleNames = header.querySelector('.couple-names');
                    const monogram = header.querySelector('.monogram');
                    if (coupleNames) coupleNames.style.fontSize = '3.5rem';
                    if (monogram) monogram.style.fontSize = '5rem';
                }
            });
        });
    </script>
</body>
</html>