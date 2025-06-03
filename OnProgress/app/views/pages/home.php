<?php
require_once __DIR__ . '/../partials/header.php';
?>
<section class="hero">
  <h2>Temukan Keindahan Semarang</h2>
  <p>Jelajahi berbagai destinasi wisata menarik di Kota Lumpia</p>
  <div class="search-bar">
        <input type="text" placeholder="Cari destinasi wisata..." />
        <button>
          <i class="fas fa-search"></i>
        </button>
      </div>
</section>
<section class="container">
  <h3>Rekomendasi Destinasi</h3>
  <div class="card-container">
    <div class="card">
      <img src="lawang sewu.jpg" alt="Lawang Sewu">
      <div class="card-content">
        <div class="card-title">Lawang Sewu <span class="card-rating">★ 4.8</span></div>
        <p>Museum bersejarah dengan banyak pintu yang ikonik di pusat kota Semarang.</p>
        <div class="tags"><span>Sejarah</span></div>
      </div>
    </div>
    <div class="card">
      <img src="sam poo kong.jpg" alt="Sam Poo Kong">
      <div class="card-content">
        <div class="card-title">Sam Poo Kong <span class="card-rating">★ 4.5</span></div>
        <p>Museum bersejarah dengan banyak pintu yang ikonik di pusat kota Semarang.</p>
        <div class="tags"><span>Sejarah</span><span>Religi</span></div>
      </div>
    </div>
    <div class="card highlight">
      <img src="umbul sidomukti.jpg" alt="Umbul Sidomukti">
      <div class="card-content">
        <div class="card-title">Umbul Sidomukti <span class="card-rating">★ 4.3</span></div>
        <p>Museum bersejarah dengan banyak pintu yang ikonik di pusat kota Semarang.</p>
        <div class="tags"><span>Alam</span></div>
      </div>
    </div>
  </div>
  <button class="see-all-button">Lihat Semua Destinasi</button>
</section>
<?php
// Panggil footer
require_once __DIR__ . '/../partials/footer.php';
?>