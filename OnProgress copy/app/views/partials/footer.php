<footer>
    <div class="footer-divider"></div>
    <p class="footer-text">Contact Us :</p>
    <p class="footer-contact">contactdiscoversemarang@gmail.com</p>
    <?php if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1'): ?>
        <div class="mt-3 text-center">
            <small class="text-muted">DEV TOOLS:</small>
            <?php
            $roles = ['visitor', 'user', 'admin', 'superadmin'];
            foreach ($roles as $role): ?>
                <a href="index.php?page=switch-role&role=<?= $role ?>" 
                   class="btn btn-sm btn-outline-secondary ms-1">
                    <?= ucfirst($role) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</footer>
    <script src="/PJBL/OnProgress%20copy/public/assets/js/script.js"></script>
</body>
</html>