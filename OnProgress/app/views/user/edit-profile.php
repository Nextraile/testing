<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="profile-wrapper">
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php if ($user['foto_profil'] && $user['foto_profil'] !== 'default.svg'): ?>
                <img src="assets/img/profiles/<?= htmlspecialchars($user['foto_profil']) ?>" class="image-profile">
            <?php else: ?>
                <img src="assets/img/profiles/default.svg" style="image-profile">
            <?php endif; ?>
        </div>
    </div>

    <div class="form-container">
        <div>
        <span class="username"><?= htmlspecialchars($user['username']) ?></span>
        <span class="date-registered">Bergabung sejak <?= htmlspecialchars($user['tanggal_register_formatted']) ?></span>
        </div>

    <form action="index.php?page=update-profile" method="POST" enctype="multipart/form-data">
        <span class="information-profile">Informasi Profil</span>

        <?php if (!empty($_SESSION['error'])): ?>
            <div>
                <ul>
                    <?php foreach ($_SESSION['error'] as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['error']); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="edit-section">
        <div class="form-username-email">
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-input" id="username" name="username"
                value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-input" id="email" name="email"
                value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
    </div>
        <div class="form-password">
        <div class="form-group">
            <label class="form-label">Password Baru</label>
            <input type="password" class="form-input" id="password" name="password" placeholder="Hanya untuk mengubah password">
        </div>
        <div class="form-group" style="margin-bottom: 20px">
            <label class="form-label">Password Konfirmasi</label>
            <input type="password" class="form-input" id="confirm_password" name="confirm_password" placeholder="Hanya untuk mengubah password">
        </div>
    </div>
</div>
        <div class="form-group upload-image" style="margin-bottom: 10px">
            <label for="foto_profil" class="upload-btn">Upload Foto Profil</label>
            <input type="file" id="foto_profil" name="foto_profil" accept="image/*" hidden>
        </div>
        <div class="save-cancel-buttons">
            <button type="submit" class="btn btn-save">Simpan</button>
            <a href="index.php?page=profile" class="btn btn-cancel">Batal</a>
        </div>
        
    </form>
</div>
</div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>