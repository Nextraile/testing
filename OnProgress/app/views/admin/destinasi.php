<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Management Destinasi</h1>
        <a href="?page=create" class="btn btn-primary">Tambah Destinasi</a>
    </div>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <div class="card-admin mb-4">
        <div class="card-body">
            <form method="GET" class="d-flex">
                <input type="hidden" name="page" value="destinasi">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari destinasi atau kategori..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>
    </div>
    
    <div class="card-admin">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($destinasi) > 0): ?>
                            <?php foreach ($destinasi as $d): ?>
                                <tr>
                                    <td><?= $d['id'] ?></td>
                                    <td><?= htmlspecialchars($d['nama']) ?></td>
                                    <td><?= htmlspecialchars($d['kategori'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?= number_format($d['rating'] ?? 0, 1) ?>
                                            <i class="bi bi-star-fill ms-1"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="delete_id" value="<?= $d['id'] ?>">
                                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-info-circle display-6 text-muted mb-3"></i>
                                    <p class="h5 text-muted">Tidak ada data destinasi</p>
                                    <p class="text-muted">Coba gunakan kata kunci pencarian yang berbeda</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Total data: <strong><?= $totalDestinasi ?></strong> destinasi
                </div>
                
                <nav>
                    <ul class="pagination mb-0">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=destinasi&p=<?= $currentPage-1 ?>&search=<?= urlencode($search ?? '') ?>">
                                    &laquo;
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php 
                        // Tampilkan maksimal 5 halaman di pagination
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $startPage + 4);
                        
                        if ($endPage - $startPage < 4) {
                            $startPage = max(1, $endPage - 4);
                        }
                        
                        for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?page=destinasi&p=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=destinasi&p=<?= $currentPage+1 ?>&search=<?= urlencode($search ?? '') ?>">
                                    &raquo;
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>