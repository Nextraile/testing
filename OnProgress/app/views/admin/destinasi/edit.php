<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container-edit py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Destinasi</h1>
        
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
    
    <form action="index.php?page=admin_destinasi_edit&id=<?= $destinasi['id'] ?>" method="post" enctype="multipart/form-data">
        <?php include '_form_edit.php'; ?>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-yellow">Perbarui Destinasi</button>
            <a href="?page=destinasi" class="btn btn-black" style="display: flex; align-items: center; justify-content: center">Kembali</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>