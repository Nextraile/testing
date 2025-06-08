document.addEventListener("DOMContentLoaded", function () {
      const menuToggle = document.getElementById("menu-toggle");
      const Links = document.getElementById("links");

      menuToggle.addEventListener("click", () => {
        Links.classList.toggle("show");
      });


    });

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk konfirmasi hapus destinasi
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            if (confirm('Apakah Anda yakin ingin menghapus destinasi ini?')) {
                form.submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menambah tiket
    document.getElementById('btn-add-tiket').addEventListener('click', function() {
        const container = document.getElementById('tiket-container');
        const index = container.children.length;
        
        const div = document.createElement('div');
        div.className = 'tiket-item mb-3 border p-3';
        div.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Kategori Pengunjung</label>
                    <input type="text" name="tiket[${index}][kategori_pengunjung]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Weekday (Rp)</label>
                    <input type="number" name="tiket[${index}][harga_weekday]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Weekend (Rp)</label>
                    <input type="number" name="tiket[${index}][harga_weekend]" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-tiket">Hapus</button>
                </div>
            </div>
            <div class="mt-2">
                <label class="form-label">Keterangan</label>
                <input type="text" name="tiket[${index}][keterangan]" class="form-control">
            </div>
        `;
        
        container.appendChild(div);
        attachRemoveEvent(div.querySelector('.btn-remove-tiket'));
    });

    // Fungsi untuk menambah waktu operasional
    document.getElementById('btn-add-waktu').addEventListener('click', function() {
        const container = document.getElementById('waktu-container');
        const index = container.children.length;
        
        const div = document.createElement('div');
        div.className = 'waktu-item mb-3 border p-3';
        div.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Hari</label>
                    <select name="waktu[${index}][nama_hari]" class="form-select">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Buka</label>
                    <input type="time" name="waktu[${index}][jam_buka]" class="form-control" value="08:00">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Tutup</label>
                    <input type="time" name="waktu[${index}][jam_tutup]" class="form-control" value="17:00">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-waktu">Hapus</button>
                </div>
            </div>
            <div class="mt-2">
                <label class="form-label">Keterangan (Opsional)</label>
                <input type="text" name="waktu[${index}][keterangan]" class="form-control" placeholder="Contoh: Libur Nasional">
            </div>
        `;
        
        container.appendChild(div);
        attachRemoveEvent(div.querySelector('.btn-remove-waktu'));
    });

    // Fungsi untuk menghapus item
    function attachRemoveEvent(button) {
        button.addEventListener('click', function() {
            const container = this.closest('#tiket-container, #waktu-container');
            const items = container.querySelectorAll('.tiket-item, .waktu-item');
            
            if (items.length > 1) {
                this.closest('.tiket-item, .waktu-item').remove();
                reindexForms();
            } else {
                alert('Minimal harus ada satu entri');
            }
        });
    }

    // Reindex semua form setelah penghapusan
    function reindexForms() {
        reindexFormItems('tiket-container', 'tiket');
        reindexFormItems('waktu-container', 'waktu');
    }

    function reindexFormItems(containerId, prefix) {
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll('.tiket-item, .waktu-item');
        
        items.forEach((item, index) => {
            // Update input names
            item.querySelectorAll('input, select').forEach(element => {
                const name = element.getAttribute('name');
                if (name && name.startsWith(prefix)) {
                    const newName = name.replace(
                        new RegExp(`${prefix}\\[\\d+\\]`), 
                        `${prefix}[${index}]`
                    );
                    element.setAttribute('name', newName);
                }
            });
        });
    }

    // Attach event listeners to existing buttons
    document.querySelectorAll('.btn-remove-tiket, .btn-remove-waktu').forEach(button => {
        attachRemoveEvent(button);
    });
});

document.addEventListener('DOMContentLoaded', function() {
// Fungsi untuk menambah tiket (di halaman edit)
document.getElementById('btn-add-tiket-edit').addEventListener('click', function() {
    const container = document.getElementById('tiket-container');
    const newId = 'new_' + Date.now(); // Format kunci baru
    
    const div = document.createElement('div');
    div.className = 'tiket-item mb-3 border p-3';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Kategori Pengunjung</label>
                <input type="text" name="tiket[${newId}][kategori_pengunjung]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Harga Weekday (Rp)</label>
                <input type="number" name="tiket[${newId}][harga_weekday]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Harga Weekend (Rp)</label>
                <input type="number" name="tiket[${newId}][harga_weekend]" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove-tiket">Hapus</button>
            </div>
        </div>
        <div class="mt-2">
            <label class="form-label">Keterangan</label>
            <input type="text" name="tiket[${newId}][keterangan]" class="form-control">
        </div>
    `;
    
    container.appendChild(div);
    attachRemoveEvent(div.querySelector('.btn-remove-tiket'));
});

// Fungsi untuk menambah waktu operasional baru
document.getElementById('btn-add-waktu-edit').addEventListener('click', function() {
    const container = document.getElementById('waktu-container');
    const newId = 'new_' + Date.now(); // Format kunci baru
    
    const div = document.createElement('div');
    div.className = 'waktu-item mb-3 border p-3';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Hari</label>
                <select name="waktu[${newId}][nama_hari]" class="form-select">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jam Buka</label>
                <input type="time" name="waktu[${newId}][jam_buka]" class="form-control" value="08:00">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jam Tutup</label>
                <input type="time" name="waktu[${newId}][jam_tutup]" class="form-control" value="17:00">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove-waktu">Hapus</button>
            </div>
        </div>
        <div class="mt-2">
            <label class="form-label">Keterangan (Opsional)</label>
            <input type="text" name="waktu[${newId}][keterangan]" class="form-control" placeholder="Contoh: Libur Nasional">
        </div>
    `;
    
    container.appendChild(div);
    attachRemoveEvent(div.querySelector('.btn-remove-waktu'));
});

document.querySelectorAll('.btn-remove-tiket').forEach(button => {
    button.addEventListener('click', function() {
        const item = this.closest('.tiket-item');
        item.remove();
    });
});

// Untuk waktu
document.querySelectorAll('.btn-remove-waktu').forEach(button => {
    button.addEventListener('click', function() {
        const item = this.closest('.waktu-item');
        item.remove();
    });
});
});