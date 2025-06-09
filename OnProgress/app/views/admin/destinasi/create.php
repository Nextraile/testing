<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container-edit py-4">
    <h1 class="new-title">Tambah Destinasi Baru</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert card-add">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?page=create" method="post" enctype="multipart/form-data">
        <?php include '_form.php'; ?>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-yellow">Simpan Destinasi</button>
            <a href="?page=destinasi" class="btn btn-black" style="display: flex; align-items: center; justify-content: center">Batal</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>