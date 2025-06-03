<?php require_once __DIR__ . '/../partials/header.php'; ?>



<div class="profile-wrapper">
<div class="profile-container">
      <div class="profile-header">
        <div class="profile-avatar">
    <?php if ($user['foto_profil'] && $user['foto_profil'] !== 'default.svg'): ?>
        <img src="assets/img/profiles/<?= htmlspecialchars($user['foto_profil']) ?>" class="image-profile">
    <?php else: ?>
        <img src="assets/img/profiles/default.svg" class="image-profile">
    <?php endif; ?>
</div>
      </div>
      <div class="profile-info">
        <h2>Informasi Profil</h2>
        <div class="profile-details">
<div class="form-group">
            <label for="username" class="form-label">Username :</label>
            <input type="text" class="form-input" id="username" name="username"
                value="<?= htmlspecialchars($user['username']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="email" class="form-input" id="email" name="email"
                value="<?= htmlspecialchars($user['email']) ?>" readonly>
        </div>
          <div class="label">Bergabung sejak :</div>
          <div class="value">15 Juni 2025</div>
        </div>
        <div class="button-container">
           <a href="pjblprofile.html" class="btn btn-yellow">Edit</a>
          <a href="#" class="btn btn-dark">Logout</a>
          <a href="#" class="btn btn-yellow">Admin Panel</a>
        </div>
      </div>
    </div>
  </div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>