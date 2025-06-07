<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Tambah Destinasi Baru</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?page=create" method="post" enctype="multipart/form-data">
        <?php include '_form.php'; ?>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Destinasi</button>
            <a href="?page=destinasi" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>