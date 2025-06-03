<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Daftar Akun Baru</h4>
        </div>
        
        <div class="card-body">
          <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                  <li><?= $error ?></li>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
              </ul>
            </div>
          <?php endif; ?>
          
          <form action="index.php?page=do-register" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" 
                     value="<?= htmlspecialchars($_SESSION['old']['username'] ?? '') ?>" required>
              <?php unset($_SESSION['old']['username']); ?>
            </div>
            
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" 
                     value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" required>
              <?php unset($_SESSION['old']['email']); ?>
            </div>
            
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
          </form>
          
          <div class="mt-3 text-center">
            <p>Sudah punya akun? <a href="index.php?page=login">Login disini</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>