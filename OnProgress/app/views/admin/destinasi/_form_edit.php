<!-- Informasi Utama -->
<div class="card-add mb-4">
    <div class="card-header">Informasi Utama</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama Destinasi</label>
            <input type="text" name="nama" class="form-control"
                value="<?= htmlspecialchars($destinasi['nama'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4"
                required><?= htmlspecialchars($destinasi['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Rekomendasi</label>
            <textarea name="deskripsi_rekomendasi" class="form-control"
                rows="3"><?= htmlspecialchars($destinasi['deskripsi_rekomendasi'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2"
                required><?= htmlspecialchars($destinasi['alamat'] ?? '') ?></textarea>
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
                    value="<?= htmlspecialchars($destinasi['no_telepon'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Facebook</label>
                <input type="text" name="facebook" class="form-control"
                    value="<?= htmlspecialchars($destinasi['facebook'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Instagram</label>
                <input type="text" name="instagram" class="form-control"
                    value="<?= htmlspecialchars($destinasi['instagram'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Google Maps Link</label>
                <input type="text" name="gmaps_link" class="form-control"
                    value="<?= htmlspecialchars($destinasi['gmaps_link'] ?? '') ?>" required>
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
                                <?= in_array($kategori['id'], $selectedKategori) ? 'checked' : '' ?>>
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
            <?php foreach ($tiketList as $index => $tiket): ?>
                <div class="tiket-item mb-3 border p-3">
                    <input type="hidden" name="tiket[<?= $tiket['id'] ?>][id]" value="<?= $tiket['id'] ?>">
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                        <div class="col-md-4">
                            <label class="form-label">Kategori Pengunjung</label>
                            <input type="text" name="tiket[<?= $tiket['id'] ?>][kategori_pengunjung]" class="form-control"
                                value="<?= htmlspecialchars($tiket['kategori_pengunjung'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Weekday (Rp)</label>
                            <input type="number" name="tiket[<?= $tiket['id'] ?>][harga_weekday]" class="form-control"
                                value="<?= htmlspecialchars($tiket['harga_weekday'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Weekend (Rp)</label>
                            <input type="number" name="tiket[<?= $tiket['id'] ?>][harga_weekend]" class="form-control"
                                value="<?= htmlspecialchars($tiket['harga_weekend'] ?? '') ?>">
                        </div>
                        <div style="margin-top: 2rem">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hapus_tiket[]"
                                    value="<?= $tiket['id'] ?>" id="hapus_tiket_<?= $tiket['id'] ?>">
                                <label class="form-check-label text-danger" for="hapus_tiket_<?= $tiket['id'] ?>">
                                    Hapus Tiket
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="tiket[<?= $tiket['id'] ?>][keterangan]" class="form-control"
                            value="<?= htmlspecialchars($tiket['keterangan'] ?? '') ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="btn-add-tiket-edit" class="btn button-add-new">Tambah Tiket</button>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Waktu Operasional</div>
    <div class="card-body">
        <div id="waktu-container">
            <?php foreach ($waktuList as $index => $waktu): ?>
                <div class="waktu-item mb-3 border p-3">
                    <input type="hidden" name="waktu[<?= $waktu['id'] ?>][id]" value="<?= $waktu['id'] ?>">
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                        <div class="col-md-3">
                            <label class="form-label">Hari</label>
                            <select name="waktu[<?= $waktu['id'] ?>][nama_hari]" class="form-select">
                                <option value="Senin" <?= $waktu['nama_hari'] == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                <option value="Selasa" <?= $waktu['nama_hari'] == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                <option value="Rabu" <?= $waktu['nama_hari'] == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                <option value="Kamis" <?= $waktu['nama_hari'] == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                <option value="Jumat" <?= $waktu['nama_hari'] == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                <option value="Sabtu" <?= $waktu['nama_hari'] == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                <option value="Minggu" <?= $waktu['nama_hari'] == 'Minggu' ? 'selected' : '' ?>>Minggu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jam Buka</label>
                            <input type="time" name="waktu[<?= $waktu['id'] ?>][jam_buka]" class="form-control"
                                value="<?= htmlspecialchars(substr($waktu['jam_buka'] ?? '08:00', 0, 5)) ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jam Tutup</label>
                            <input type="time" name="waktu[<?= $waktu['id'] ?>][jam_tutup]" class="form-control"
                                value="<?= htmlspecialchars(substr($waktu['jam_tutup'] ?? '17:00', 0, 5)) ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hapus_waktu[]"
                                    value="<?= $waktu['id'] ?>" id="hapus_waktu_<?= $waktu['id'] ?>">
                                <label class="form-check-label text-danger" for="hapus_waktu_<?= $waktu['id'] ?>">
                                    Hapus Jadwal
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="waktu[<?= $waktu['id'] ?>][keterangan]" class="form-control"
                            value="<?= htmlspecialchars($waktu['keterangan'] ?? '') ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="btn-add-waktu-edit" class="btn button-add-new">Tambah Jadwal</button>
    </div>
</div>

<div class="card-add mb-4">
    <div class="card-header">Galeri Gambar</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label>
            <div class="form-row" >
                <?php foreach ($gambarList as $gambar): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card-add" style="width: 20rem; border-radius: 0.4rem; overflow: hidden;">
                            <img src="<?= BASE_URL ?>assets/img/destinasi/<?= $gambar['nama_file'] ?>" class="card-img-top"
                                alt="Gambar Destinasi" style="width: 100%; height: 150px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hapus_gambar[]"
                                        value="<?= $gambar['id'] ?>" id="hapus_<?= $gambar['id'] ?>">
                                    <label class="form-check-label text-danger" for="hapus_<?= $gambar['id'] ?>">
                                        Hapus
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tambah Gambar Baru</label>
            <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
        </div>
    </div>
</div>