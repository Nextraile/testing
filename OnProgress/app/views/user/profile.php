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
            <span class="title-info">Informasi Profil</span>
            <div class="profile-details">
                <div class="username-container">
                    <span>Username :</span>
                    <span class="profile-text"><?= htmlspecialchars($user['username']) ?></span>
                </div>
                <div class="email-container">
                    <span>Email :</span>
                    <span class="profile-text"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="date-registered-container">
                <span>Bergabung sejak :</span>
                <span class="profile-text"><?= htmlspecialchars($user['tanggal_register_formatted']) ?></span>
                </div>
            </div>
            <div class="button-container">
                <a href="index.php?page=edit-profile" class="btn btn-yellow">Edit</a>
                <a href="index.php?page=logout" class="btn btn-black">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>