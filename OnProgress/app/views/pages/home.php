<?php
require_once __DIR__ . '/../partials/header.php';
?>
<div style="background-color: #f3f4f6;">
  <section class="hero">
    <h2>Temukan Keindahan Semarang</h2>
    <p>Jelajahi berbagai destinasi wisata menarik di Kota Lumpia</p>
    <form class="search-form" action="?page=list" method="GET">
      <div class="search-bar">
        <input type="text" name="search" placeholder="Cari destinasi wisata..." />
        <button type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>

  </section>
  <section class="container" style="margin: 2rem;">
    <h1 style="text-align: center; font-size: 2rem; margin: 1rem;">Rekomendasi Destinasi</h1>
    <div class="card-container" style="display: flex; justify-content: center; align-items: flex-start; gap: 2rem; ">
      <?php if (count($rekomendasi) > 0): ?>
        <?php foreach ($rekomendasi as $destinasi): ?>
          <div class="card"
            style="border: none; box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.1); -webkit-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.1); -moz-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.1); cursor: pointer;"
            onclick="window.location='?page=detail&id=<?= $destinasi['id'] ?>'">
            <img src="<?= BASE_URL ?>assets/img/destinasi/<?= $destinasi['gambar'] ?>" alt="<?= $destinasi['gambar'] ?>">
            <div class="card-content" style="padding: 1rem;">
              <h4 class="card-title"><?= htmlspecialchars($destinasi['nama']) ?><span class="card-rating"><i
                    class="fa-solid fa-star" style="color: #ffd43b;"></i>
                  <?= number_format($destinasi['rating'], 1) ?>
                </span>
              </h4>
              <p class="card-text text-muted"><?= htmlspecialchars($destinasi['deskripsi_rekomendasi']) ?></p>
              <div class="tags">
                <?php
                $kategoriList = explode(', ', $destinasi['kategori']);
                foreach ($kategoriList as $kategori):
                  if (!empty(trim($kategori))):
                    ?>
                    <span><?= htmlspecialchars($kategori) ?></span>
                  

                  <?php
                  endif;
                endforeach;
                ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center py-5">
          <i class="bi bi-info-circle display-5 text-muted mb-3"></i>
          <p class="h5 text-muted">Belum ada destinasi rekomendasi</p>
        </div>
      <?php endif; ?>
    </div>
  </section>
  <?php
  // Panggil footer
  require_once __DIR__ . '/../partials/footer.php';