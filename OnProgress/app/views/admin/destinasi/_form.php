<div class="card-add mb-4">
    <div class="card-header">Informasi Utama</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama Destinasi</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"
                rows="4"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Rekomendasi</label>
            <textarea name="deskripsi_rekomendasi" class="form-control"
                rows="3"><?= htmlspecialchars($_POST['deskripsi_rekomendasi'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control"
                rows="2"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
        </div>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Kontak & Media Sosial</div>
    <div class="card-body">
        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr;">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="no_telepon" class="form-control"
                    value="<?= htmlspecialchars($_POST['no_telepon'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Facebook</label>
                <input type="text" name="facebook" class="form-control"
                    value="<?= htmlspecialchars($_POST['facebook'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Instagram</label>
                <input type="text" name="instagram" class="form-control"
                    value="<?= htmlspecialchars($_POST['instagram'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Google Maps Link</label>
                <input type="text" name="gmaps_link" class="form-control"
                    value="<?= htmlspecialchars($_POST['gmaps_link'] ?? '') ?>">
            </div>
        </div>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Kategori</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" style="margin-top: 0;">Pilih Kategori</label>
            <div class="form-row">
                <?php foreach ($kategoriList as $kategori): ?>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kategori[]" value="<?= $kategori['id'] ?>"
                                <?= in_array($kategori['id'], $_POST['kategori'] ?? []) ? 'checked' : '' ?>>
                            <label class="form-check-label"><?= htmlspecialchars($kategori['nama_kategori']) ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Tiket Masuk</div>
    <div class="card-body">
        <div id="tiket-container">
            <?php $tiketCount = max(1, count($_POST['tiket'] ?? [])); ?>
            <?php for ($i = 0; $i < $tiketCount; $i++): ?>
                <div class="tiket-item mb-3 border p-3">
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                        <div class="col-md-4">
                            <label class="form-label">Kategori Pengunjung</label>
                            <input type="text" name="tiket[<?= $i ?>][kategori_pengunjung]" class="form-control"
                                value="<?= htmlspecialchars($_POST['tiket'][$i]['kategori_pengunjung'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Weekday (Rp)</label>
                            <input type="number" name="tiket[<?= $i ?>][harga_weekday]" class="form-control"
                                value="<?= htmlspecialchars($_POST['tiket'][$i]['harga_weekday'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Weekend (Rp)</label>
                            <input type="number" name="tiket[<?= $i ?>][harga_weekend]" class="form-control"
                                value="<?= htmlspecialchars($_POST['tiket'][$i]['harga_weekend'] ?? '') ?>">
                        </div>
                        <div style="margin-top: 2rem;">
                            <button type="button" class="btn btn-remove-tiket">Hapus</button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="tiket[<?= $i ?>][keterangan]" class="form-control"
                            value="<?= htmlspecialchars($_POST['tiket'][$i]['keterangan'] ?? '') ?>">
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <button type="button" id="btn-add-tiket" class="btn button-add-new">Tambah Tiket</button>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Waktu Operasional</div>
    <div class="card-body">
        <div id="waktu-container">
            <?php $waktuCount = max(1, count($_POST['waktu'] ?? [])); ?>
            <?php for ($i = 0; $i < $waktuCount; $i++): ?>
                <div class="waktu-item mb-3 border p-3">
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                        <div class="col-md-3">
                            <label class="form-label">Hari</label>
                            <select name="waktu[<?= $i ?>][nama_hari]" class="form-select">
                                <option value="Senin" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                <option value="Selasa" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                <option value="Rabu" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                <option value="Kamis" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                <option value="Jumat" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                <option value="Sabtu" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                <option value="Minggu" <?= ($_POST['waktu'][$i]['nama_hari'] ?? '') == 'Minggu' ? 'selected' : '' ?>>Minggu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jam Buka</label>
                            <input type="time" name="waktu[<?= $i ?>][jam_buka]" class="form-control"
                                value="<?= htmlspecialchars($_POST['waktu'][$i]['jam_buka'] ?? '08:00') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jam Tutup</label>
                            <input type="time" name="waktu[<?= $i ?>][jam_tutup]" class="form-control"
                                value="<?= htmlspecialchars($_POST['waktu'][$i]['jam_tutup'] ?? '17:00') ?>">
                        </div>
                        <div style="margin-top: 2rem;">
                            <button type="button" class="btn btn-remove-waktu">Hapus</button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="waktu[<?= $i ?>][keterangan]" class="form-control"
                            value="<?= htmlspecialchars($_POST['waktu'][$i]['keterangan'] ?? '') ?>">
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <button type="button" id="btn-add-waktu" class="btn button-add-new">Tambah Jadwal</button>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Galeri Gambar</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Upload Gambar</label>
            <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
        </div>
    </div>
</div>