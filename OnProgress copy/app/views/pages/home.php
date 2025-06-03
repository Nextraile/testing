<?php
// Panggil header
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container">
    <h1>Destinasi Wisata Semarang</h1>
    
    <div class="row">
        <?php foreach ($destinasiList as $destinasi): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($destinasi['nama']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars(substr($destinasi['deskripsi'], 0, 100))) ?>...</p>
                        <a href="index.php?page=detail&id=<?= $destinasi['id'] ?>" class="btn btn-primary">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
// Panggil footer
require_once __DIR__ . '/../partials/footer.php';
?>