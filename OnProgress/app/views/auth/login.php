<?php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="login-page">
    <div class="form-container">
        <h1>Login</h1>
        <div>
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
        </div>
        <form action="index.php?page=do-login" method="POST">
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
            <button type="submit" class="submit-btn">Continue</button>
        </form>
        <div class="bottom-text">
            <p>Belum punya akun? <a href="index.php?page=register">Register</a></p>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>