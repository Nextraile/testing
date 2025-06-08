<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Destinasi</h1>
        <a href="?page=destinasi" class="btn btn-secondary">Kembali</a>
    </div>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="?page=admin_destinasi_edit&id=<?= $destinasi['id'] ?>" method="post" enctype="multipart/form-data">
        <?php include '_form_edit.php'; ?>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Perbarui Destinasi</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>