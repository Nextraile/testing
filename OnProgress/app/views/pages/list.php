<?php
require_once __DIR__ . '/../partials/header.php';
?>
<div style="background-color: #f3f4f6;">
    <div class="container" style="min-height: 100dvh;">
        <!-- Judul Halaman -->
        <div style="display: flex; justify-content: center;">
            <h1 style="margin: 40px 0px 20px 0px">List Destinasi Wisata</h1>
        </div>

        <form method="get" action="?page=list&" id="filterForm">
            <div class="search-bar">
                <input type="hidden" name="page" value="list">
                <input type="text" name="search" placeholder="Cari destinasi wisata..."
                    value="<?= htmlspecialchars($keyword ?? '') ?>">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="kategori-wrapper" id="kategoriContainer">
                <?php foreach ($kategoriList as $kategori): ?>
                    <div class="form-check">
                        <input hidden class="form-check-input" type="checkbox" name="kategori[]"
                            value="<?= $kategori['id'] ?>" id="kategori-<?= $kategori['id'] ?>" <?= in_array($kategori['id'], $kategoriIds) ? 'checked' : '' ?>>
                        <label class="kategori" for="kategori-<?= $kategori['id'] ?>">
                            <?= htmlspecialchars($kategori['nama_kategori']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="display: flex; align-items: center; justify-content: center; margin: 20px 0px; gap: 10px;">
                <button type="submit" class="btn btn-yellow btn-sm">
                    Terapkan Filter
                </button>

                <?php if (!empty($kategoriIds) || !empty($keyword)): ?>
                    <a href="?page=list" class="btn btn-black btn-sm">
                        Reset Filter
                    </a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Hasil Pencarian -->
        <div class="grid-container">
            <?php if (count($destinasiList) > 0): ?>
                <?php foreach ($destinasiList as $destinasi): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4" style="cursor: pointer;"
                        onclick="window.location='?page=detail&id=<?= $destinasi['id'] ?>'">
                        <div class="card-list h-100 shadow-sm">
                            <?php if ($destinasi['gambar']): ?>
                                <img src="<?= BASE_URL ?>assets/img/destinasi/<?= $destinasi['gambar'] ?>" class="card-img-list"
                                    alt="<?= htmlspecialchars($destinasi['nama']) ?>" style="height: 180px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                    style="height: 180px;">
                                    <span class="text-muted">Tidak ada gambar</span>
                                </div>
                            <?php endif; ?>

                            <div class="card-body-list">
                                <h3 class="h5 card-title-list fw-bold"><?= htmlspecialchars($destinasi['nama']) ?></h3>
                                <span class="card-rating-list">
                                    <i class="fa-solid fa-star" style="color: #ffd43b;"></i>
                                    <?= number_format($destinasi['rating'] ?? 0, 1) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
        
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; justify-content: center;">
                    <p>Tidak ada destinasi yang ditemukan</p>
                    <p>Coba gunakan kata kunci atau filter yang berbeda</p>
                </div>
            <?php endif; ?>
        </div>


        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination-container" style="justify-content: center; padding-bottom: 40px;">
                <ul class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="prevBtn"
                                href="?<?= http_build_query(array_merge($_GET, ['p' => $currentPage - 1])) ?>">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $startPage + 4);

                    if ($endPage - $startPage < 4) {
                        $startPage = max(1, $endPage - 4);
                    }

                    for ($i = $startPage; $i <= $endPage; $i++):
                        ?>
                        <li class="page-item">
                            <a class="page-link <?= $i == $currentPage ? 'active' : '' ?>" href="?<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="nextBtn"
                                href="?<?= http_build_query(array_merge($_GET, ['p' => $currentPage + 1])) ?>">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                </div>
        <?php endif; ?>
    </div>
</div>
<?php
require_once __DIR__ . '/../partials/footer.php';
?>