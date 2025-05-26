<?php
require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<section class="hero">
    <div class="hero-content">
        <h2>Temukan Keindahan Semarang</h2>
        <p>Jelajahi berbagai destinasi wisata menarik di Kota Lumpia</p>
        <div class="search-box">
            <form action="search.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Cari tempat wisata..." required>
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>
</section>

  <section class="rekomendasi">
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



  <!-- Hero Section -->
  <section class="hero" style="background-image: url('assets/img/bg-alam.jpg');">
    <div class="overlay">
      <div class="hero-content">
        <h1>Selamat Datang di WisataKita</h1>
        <p>Temukan destinasi wisata terbaik di sekitarmu!</p>

        <!-- Search Bar -->
        <form action="search.php" method="GET" class="search-form">
          <input type="text" name="query" placeholder="Cari tempat wisata..." required>
          <button type="submit">Cari</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Rekomendasi Section -->
  <section class="rekomendasi">
    <div class="container">
      <h2>Rekomendasi untuk Anda</h2>
      <div class="card-wrapper">
        <?php
          /* Contoh dummy data rekomendasi
          include 'includes/db.php';

          $query = "SELECT * FROM places ORDER BY rating DESC LIMIT 6";
          $result = mysqli_query($conn, $query);

          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card">';
            echo '<img src="assets/img/places/' . $row['image'] . '" alt="' . $row['name'] . '">';
            echo '<div class="card-body">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p>' . $row['location'] . '</p>';
            echo '<a href="detail.php?id=' . $row['id'] . '" class="btn">Lihat Detail</a>';
            echo '</div>';
            echo '</div>';
          } */
        ?>
      </div>
    </div>
  </section>
<?php
require_once 'partials/footer.php';
?>