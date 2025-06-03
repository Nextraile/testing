<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Daftar Destinasi Wisata Semarang</h1>
    
    <!-- Search Form -->
    <form class="mb-4" method="GET" action="index.php">
        <input type="hidden" name="page" value="list">
        <div class="input-group">
            <input type="text" class="form-control" 
                   name="search" placeholder="Cari destinasi..." 
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>
    
    <!-- List Destinasi -->
    <div class="row">
        <?php if (empty($destinasiList)): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada destinasi yang ditemukan.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($destinasiList as $destinasi): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <!-- Gambar Utama -->
                        <?php if ($destinasi['gambar_utama']): ?>
                            <img src="/assets/images/destinasi/<?= htmlspecialchars($destinasi['gambar_utama']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($destinasi['nama']) ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-white fs-1"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($destinasi['nama']) ?></h5>
                            <p class="card-text text-muted">
                                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($destinasi['alamat']) ?>
                            </p>
                            <a href="index.php?page=detail&id=<?= $destinasi['id'] ?>" 
                               class="btn btn-primary">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
                <!-- Previous Page -->
                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" 
                       href="index.php?page=list&p=<?= $currentPage - 1 ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
                        &laquo; Sebelumnya
                    </a>
                </li>
                
                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" 
                           href="index.php?page=list&p=<?= $i ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <!-- Next Page -->
                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" 
                       href="index.php?page=list&p=<?= $currentPage + 1 ?><?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
                        Selanjutnya &raquo;
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>