<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="register-page">
    <div class="form-container">
        <h1>Register</h1>
        <div>
            <?php if (!empty($_SESSION['errors'])): ?>
                <div>
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $errors): ?>
                            <li><?= $errors ?></li>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['errors']); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <form action="index.php?page=do-register" method="POST">
            <div>
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-input" id="username" name="username" required>
            </div>
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-input" id="email" name="email" required>
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-input" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-input" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="submit-btn">Continue</button>
        </form>
        <div class="bottom-text">
            <p>Sudah punya akun? <a href="index.php?page=login">Login</a></p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
