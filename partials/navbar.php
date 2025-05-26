<!-- partials/navbar.php -->
<?php
  require_once __DIR__ . '/../includes/session.php';
?>
<nav>
  <div class="nav-container">
    <div style="font-weight: bold; font-size: 1.2rem;">Discover Semarang</div>  
      <ul>
        <li><a class="outside-button" href="/index.php">Beranda</a></li>
        <li><a class="outside-button" href="/list-destinasi.php">List Destinasi</a></li>
      <?php if (isset($_SESSION['role'])): ?>
        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'superadmin'): ?>
          <li><a class="outside-button" href="/admin/index.php">Admin Panel</a></li>
        <?php endif; ?>
        <li><a class="account-button" href="/profile.php">
        <svg xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" width="18" height="18">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>Akun</a></li>
      <?php else: ?>
        <li><a class="login-button" href="auth/login.php">Login</a></li>
      <?php endif; ?>
      </ul>
  </div>
</nav>