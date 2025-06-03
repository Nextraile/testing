<?php
// Pastikan session sudah dimulai
require_once __DIR__ . '/../../../public/includes/session.php';

// Dapatkan role user
$role = get_user_role();
?>

<div class="nav-container">
  <nav class="navbar">
    <div class="logo">
      <a href="index.php?page=home">Discover Semarang</a>
    </div>

    <div class="nav-links">
      <ul class="links" id="links">
        <li><a href="index.php?page=home">Beranda</a></li>
        <li><a href="index.php?page=list">List Destinasi</a></li>
        <li><a href="index.php?page=logout">Logout</a></li>
        <?php if (is_admin()): ?>
          <li><a href="index.php?page=admin">Admin Panel</a></li>
        <?php endif; ?>
      </ul>

      <ul class="links-button">
        <?php if (is_logged_in()): ?>
          <li><a href="index.php?page=profile" class="button">
            <i class="fas fa-user" style="margin-right: 0.5rem;"></i>
            <span style="font-weight: 700;">Akun</span>
          </a></li>
        <?php else: ?>
          <li><a href="index.php?page=login" class="button" style="font-weight: 700;">
            <i class="fa-solid fa-right-to-bracket" style="margin-right: 0.5rem;"></i>Login
          </a></li>
        <?php endif; ?>
      </ul>
    </div>

    <button class="menu" id="menu-toggle">
      <i class="fa-solid fa-bars"></i>
    </button>
  </nav>
</div>

<section>