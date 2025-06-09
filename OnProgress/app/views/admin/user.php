<?php require_once __DIR__ . '/../partials/header.php'; ?>

<!-- Main Container -->
<div class="admin-container">
    <div class="main-content">
        <!-- Content Area -->
        <main class="content-area">
            <div class="content-header">
                <h1 class="content-title">Management User</h1>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success_message'] ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error_message'] ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            
                <form method="GET">
                    <div class="search-container">
                    <input type="hidden" name="page" value="akses">
                    <input type="text" name="search" class="search-input"
                        placeholder="Cari username atau email..." value="<?= htmlspecialchars($search ?? '') ?>">
                    <button type="submit" class="btn btn-black" style="font-weight: normal;">Cari</button>
                </div>
            </form>
            

            <div class="table-container">
                <table id="destinationTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Register</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <select name="new_role" class="form-select form-select-sm">
                                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                            </select>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($user['tanggal_register'])) ?></td>
                                    <td>
                                            <button type="submit" name="update_role" class="btn btn-primary btn-sm">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-info-circle display-6 text-muted mb-3"></i>
                                    <p class="h5 text-muted">Tidak ada data user</p>
                                    <p class="text-muted">Coba gunakan kata kunci pencarian yang berbeda</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


            <div class="pagination-container">
                <div class="text-muted">
                    Total data: <strong><?= $totalUsers ?></strong> user
                </div>
                <ul class="pagination mb-0">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="prevBtn"
                                href="?page=akses&p=<?= $currentPage - 1 ?>&search=<?= urlencode($search ?? '') ?>">
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
                            <a class="page-link <?= $i == $currentPage ? 'active' : '' ?>" href="?page=akses&p=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="nextBtn"
                                href="?page=akses&p=<?= $currentPage + 1 ?>&search=<?= urlencode($search ?? '') ?>">
                            <i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>