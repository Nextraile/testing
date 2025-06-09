<?php require_once __DIR__ . '/../partials/header.php'; ?>
<!-- Main Container -->
<div class="admin-container">
    <div class="main-content">
        <!-- Content Area -->
        <main class="content-area">
            <div class="content-header">
                <h1 class="content-title">Management Destinasi</h1>
                <a href="?page=create" class="btn btn-add btn-yellow" style="width: fit-content;">Tambah Destinasi</a>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert page-add">
                    <?= $_SESSION['success_message'] ?>
                    </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert page-add">
                    <?= $_SESSION['error_message'] ?>
                    </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            
                <form method="GET">
                    <div class="search-container">
                    <input type="hidden" name="page" value="destinasi">
                    <input type="text" name="search" class="search-input"
                        placeholder="Cari destinasi atau kategori..." value="<?= htmlspecialchars($search ?? '') ?>">
                    <button type="submit" class="btn btn-black" style="font-weight: normal;">Cari</button>
                </div>
            </form>
            

            <div class="table-container">
                <table id="destinationTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>KATEGORI</th>
                            <th>RATING</th>
                            <th>HAPUS</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php if (count($destinasi) > 0): ?>
                            <?php foreach ($destinasi as $d): ?>
                                <tr>
                                    <td><?= $d['id'] ?></td>
                                    <td onclick="window.location='?page=admin_destinasi_edit&id=<?= $d['id'] ?>'"
                                        style="cursor: pointer;"><?= htmlspecialchars($d['nama']) ?></td>
                                    <td onclick="window.location='?page=admin_destinasi_edit&id=<?= $d['id'] ?>'"
                                        style="cursor: pointer;"><?= htmlspecialchars($d['kategori'] ?? '-') ?></td>
                                    <td onclick="window.location='?page=admin_destinasi_edit&id=<?= $d['id'] ?>'"
                                        style="cursor: pointer;">
                                        <span class="badge bg-success">
                                            <?= number_format($d['rating'] ?? 0, 1) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="delete_id" value="<?= $d['id'] ?>">
                                            <button type="button" class="delete-btn btn-danger btn-sm btn-delete">
                                                <i class="fa-solid fa-trash-can" style="margin-right: 0.5rem;"></i>Hapus
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


            <div class="pagination-container">
                <div class="text-muted">
                    Total data: <strong><?= $totalDestinasi ?></strong> destinasi
                </div>
                <ul class="pagination mb-0">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="prevBtn"
                                href="?page=destinasi&p=<?= $currentPage - 1 ?>&search=<?= urlencode($search ?? '') ?>">
                                <i class="fa-solid fa-chevron-left"></i>
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
                        <li class="page-item">
                            <a class="page-link <?= $i == $currentPage ? 'active' : '' ?>" href="?page=destinasi&p=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="nextBtn"
                                href="?page=destinasi&p=<?= $currentPage + 1 ?>&search=<?= urlencode($search ?? '') ?>">
                            <i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>