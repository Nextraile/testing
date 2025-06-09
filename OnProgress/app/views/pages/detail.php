<?php
require_once __DIR__ . '/../partials/header.php';
?>
<section class="destinasi-container">
    <!-- Header Destinasi -->
    <div class="destinasi-header">
        <iframe
        width="100%"
        height="500px"
        frameborder="0" style="border:0"
        referrerpolicy="no-referrer-when-downgrade"
        src="<?= $destinasi['gmaps_link']?>"
        allowfullscreen>
        </iframe>
        <h1><?= htmlspecialchars($destinasi['nama']) ?></h1>
        <div class="rating-section">
            <div class="rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star <?= $i <= round($destinasi['rating']) ? 'active' : '' ?>"></i>
                <?php endfor; ?>
                <span><?= number_format($destinasi['rating'], 1) ?></span>
            </div>
            <span class="review-count">(<?= (int)$destinasi['jumlah_ulasan'] ?> ulasan)</span>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section">
        <h2>Tentang</h2>
        <p class="tanggal-dibuat">
            <i class="far fa-calendar-alt"></i>
            Tanggal dibuat: <?= date('d-m-Y', strtotime($destinasi['tanggal_dibuat'])) ?>
        </p>
        <p><?= nl2br(htmlspecialchars($destinasi['deskripsi'])) ?></p>
    </div>

<div class="informasi-section">
    <h2>Informasi</h2>
    <div class="info-grid">
        <!-- Alamat -->
        <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <h3>Alamat</h3>
                <p><?= nl2br(htmlspecialchars($destinasi['alamat'])) ?></p>
            </div>
        </div>

        <!-- Kontak -->
        <div class="info-item">
            <i class="fas fa-phone"></i>
            <div>
                <h3>Kontak</h3>
                <p><?= !empty($destinasi['no_telepon']) ? htmlspecialchars($destinasi['no_telepon']) : '-' ?></p>
            </div>
        </div>

        <!-- Instagram -->
        <div class="info-item">
            <i class="fab fa-instagram"></i>
            <div>
                <h3>Instagram</h3>
                <p><?= !empty($destinasi['instagram']) ? htmlspecialchars($destinasi['instagram']) : '-' ?></p>
            </div>
        </div>

        <!-- Facebook -->
        <div class="info-item">
            <i class="fab fa-facebook"></i>
            <div>
                <h3>Facebook</h3>
                <p><?= !empty($destinasi['facebook']) ? htmlspecialchars($destinasi['facebook']) : '-' ?></p>
            </div>
        </div>

        <!-- Jam Operasional -->
        <div class="info-item">
            <i class="fas fa-clock"></i>
            <div>
                <h3>Jam Operasional</h3>
                <?php if (!empty($operasional['weekday'])): ?>
                    <p>Weekday: <?= htmlspecialchars($operasional['weekday']) ?></p>
                <?php endif; ?>
                <?php if (!empty($operasional['weekend'])): ?>
                    <p>Weekend: <?= htmlspecialchars($operasional['weekend']) ?></p>
                <?php endif; ?>
                <?php if (!empty($operasional['keterangan']) && is_array($operasional['keterangan'])): ?>
                    <p class="keterangan"><?= htmlspecialchars(implode("\n", $operasional['keterangan'])) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Harga Tiket Masuk -->
        <div class="info-item">
            <i class="fas fa-ticket-alt"></i>
            <div>
                <h3>Harga Tiket Masuk</h3>
                <?php if (!empty($tiketMasuk) && is_array($tiketMasuk)): ?>
                    <?php foreach ($tiketMasuk as $tiket): ?>
                            <?= htmlspecialchars($tiket['kategori_pengunjung']) ?>:
                            <?php if (!empty($tiket['harga_weekday'])): ?>
                                <p>Rp <?= number_format($tiket['harga_weekday'], 0, ',', '.') ?> (Weekday)</p>
                            <?php else:?>
                                <p>Free (Weekday)</p>
                            <?php endif; ?>
                            <?php if (!empty($tiket['harga_weekday']) && !empty($tiket['harga_weekend'])): ?><br><?php endif; ?>
                            <?php if (!empty($tiket['harga_weekend'])): ?>
                                <p>Rp <?= number_format($tiket['harga_weekend'], 0, ',', '.') ?> (Weekend)</p>
                            <?php else:?>
                                <p>Free (Weekend)</p>
                            <?php endif; ?>
                    <?php endforeach; ?>
                    <?php 
                    $keteranganTiket = array_filter(array_column($tiketMasuk, 'keterangan'));
                    ?>
                    <?php if (!empty($keteranganTiket)): ?>
                        <p class="keterangan"><?= htmlspecialchars(implode("\n", $keteranganTiket)) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>-</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


    <!-- Photo Gallery -->
    <div class="gallery-section">
        <h2>Galeri Foto</h2>
        <div class="gallery">
            <?php foreach ($galeri as $foto): ?>
                <div class="gallery-item">
                    <img src="<?php BASE_URL ?>assets/img/destinasi/<?= htmlspecialchars($foto['nama_file']) ?>"
                         alt="<?= htmlspecialchars($destinasi['nama']) ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h2>Ulasan</h2>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert error"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert success">Ulasan berhasil ditambahkan!</div>
        <?php endif; ?>

        <div class="reviews-container">
            <?php foreach ($ulasan as $review): ?>
                <div class="review-item">
                    <div class="user-info">
                        <img src="/assets/images/<?= htmlspecialchars($review['foto_profil']) ?>"
                             alt="<?= htmlspecialchars($review['username']) ?>">
                        <span><?= htmlspecialchars($review['username']) ?></span>
                    </div>
                    <div class="review-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= $review['rating'] ? 'active' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="review-text"><?= nl2br(htmlspecialchars($review['isi_ulasan'])) ?></p>
                    <p class="review-date">
                        <i class="far fa-clock"></i>
                        <?= date('d M Y H:i', strtotime($review['tanggal_upload'])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Load More Button -->
        <div class="load-more">
            <button id="loadMoreBtn">
                <i class="fas fa-plus"></i> Tampilkan lebih banyak
            </button>
        </div>

        <!-- Add Review Form -->
        <div class="add-review">
            <h3>Tambahkan Ulasan</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Rating</label>
                    <div class="star-rating">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star-<?= $i ?>" name="rating" value="<?= $i ?>">
                            <label for="star-<?= $i ?>"><i class="fas fa-star"></i></label>
                        <?php endfor; ?>
                    </div>
                    <?php if (!empty($errors['rating'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['rating']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="review-text">Ulasan</label>
                    <textarea id="review-text" name="isi_ulasan" placeholder="Bagikan pengalaman anda..."></textarea>
                    <?php if (!empty($errors['isi_ulasan'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['isi_ulasan']) ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="submit-btn">Kirim ulasan</button>
            </form>
        </div>
    </div>
</section>
<?php
require_once __DIR__ . '/../partials/footer.php';
?>
