<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="index.php?page=home">
            Discover Semarang
        </a>
        
        <!-- Toggle button untuk mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu utama -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto">
                <!-- Beranda -->
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'home' ? 'active' : '' ?>" 
                       href="index.php?page=home">
                        Beranda
                    </a>
                </li>
                
                <!-- List Destinasi -->
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'list' ? 'active' : '' ?>" 
                       href="index.php?page=list">
                        List Destinasi
                    </a>
                </li>
                
                <!-- Admin Panel (hanya untuk admin & superadmin) -->
                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'superadmin')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['page'] ?? '') === 'admin' ? 'active' : '' ?>" 
                           href="index.php?page=admin">
                            Admin Panel
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <!-- Menu sisi kanan (akun/login) - SEKARANG DI DALAM COLLAPSE -->
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User sudah login -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" 
                           href="#" 
                           id="userDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <!-- Foto profil (jika ada) -->
                            <?php if (!empty($_SESSION['foto_profil'])): ?>
                                <img src="/assets/images/profiles/<?= htmlspecialchars($_SESSION['foto_profil']) ?>" 
                                     class="rounded-circle me-2" 
                                     width="30" 
                                     height="30" 
                                     alt="Foto Profil">
                            <?php else: ?>
                                <!-- Ikon default jika tidak ada foto -->
                                <i class="bi bi-person-circle me-2"></i>
                            <?php endif; ?>
                            
                            <span class="d-none d-lg-inline"><?= htmlspecialchars($_SESSION['username']) ?></span>
                        </a>
                        
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="index.php?page=profile">Profil Saya</a></li>
                            
                            <?php if ($_SESSION['role'] === 'superadmin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-warning" href="index.php?page=admin-users">Kelola Admin</a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?page=logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- User belum login -->
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="index.php?page=login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            <span class="d-none d-lg-inline">Login</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>