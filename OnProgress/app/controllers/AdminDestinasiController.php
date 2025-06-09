<?php
require_once __DIR__ . '/../models/DestinasiModel.php';
require_once __DIR__ . '/../models/KategoriModel.php';
require_once __DIR__ . '/../models/TiketModel.php';
require_once __DIR__ . '/../models/WaktuOperasionalModel.php';
require_once __DIR__ . '/../models/GaleriModel.php';

class AdminDestinasiController {
    private $db;
    private $destinasiModel;
    private $kategoriModel;
    private $tiketModel;
    private $waktuModel;
    private $galeriModel;

    public function __construct($db) {
        $this->db = $db;
        $this->destinasiModel = new DestinasiModel($db);
        $this->kategoriModel = new KategoriModel($db);
        $this->tiketModel = new TiketModel($db);
        $this->waktuModel = new WaktuOperasionalModel($db);
        $this->galeriModel = new GaleriModel($db);
    }

    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // --- AUTH & AUTHZ ---
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        if (!in_array($_SESSION['role'], ['admin', 'superadmin'], true)) {
            header('Location: index.php?page=home');
            exit;
        }

        $errors = [];
        $kategoriList = $this->kategoriModel->getAllKategori();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi input
            $errors = $this->validate($_POST, $_FILES);

            if (empty($errors)) {
                // Simpan data destinasi utama
                $destinasiId = $this->destinasiModel->addDestinasi($_POST);

                // Simpan kategori
                if (!empty($_POST['kategori'])) {
                    $this->kategoriModel->linkDestinasiKategori($destinasiId, $_POST['kategori']);
                }

                // Simpan tiket
                foreach ($_POST['tiket'] as $tiket) {
                    $this->tiketModel->addTiket($destinasiId, $tiket);
                }

                // Simpan waktu operasional
                foreach ($_POST['waktu'] as $waktu) {
                    $this->waktuModel->addWaktuOperasional($destinasiId, $waktu);
                }

                // Simpan gambar
                if (!empty($_FILES['gambar']['name'][0])) {
                    $this->simpanGambar($destinasiId, $_FILES['gambar']);
                }
                
                if (!empty($_SESSION['success_message'])) {
                    $_SESSION['success_message'] = 'Destinasi berhasil ditambahkan.';
                }

                header('Location: index.php?page=destinasi');
                exit;
            }
        }

        require_once __DIR__ . '/../views/admin/destinasi/create.php';
    }

    private function validate($post, $files) {
        $errors = [];

        // Validasi field wajib
        $required = ['nama', 'deskripsi', 'deskripsi_rekomendasi', 'alamat', 'gmaps_link'];
        foreach ($required as $field) {
            if (empty($post[$field])) {
                $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' wajib diisi';
            }
        }

        if (!empty($post['nama'])) {
            if (mb_strlen($post['nama']) > 100) {
                $errors['nama'] = 'Nama destinasi maksimal 100 karakter.';
            } elseif (preg_match('/<[^>]*>/', $post['nama'])) {
                $errors['nama'] = 'Nama destinasi tidak boleh berisi tag HTML.';
            }
        }


        // Validasi URL Google Maps
        if (empty($post['gmaps_link'])) {
            $errors['gmaps_link'] = 'Link Google Maps wajib diisi';
        } elseif (!empty($post['gmaps_link']) && !filter_var($post['gmaps_link'], FILTER_VALIDATE_URL)) {
            $errors['gmaps_link'] = 'URL Google Maps tidak valid';
        } elseif (!preg_match('/^https?:\/\/(www\.)?google\.com\/maps\/.+$/', $post['gmaps_link'])) {
            $errors['gmaps_link'] = 'Link Google Maps tidak valid. Harus dimulai dengan http:// atau https:// dan mengandung google.com/maps/';
        }

        // Validasi nomor telepon
        if (!empty($post['no_telepon'])) {
            $digitsOnly = preg_replace('/\D+/', '', $post['no_telepon']);
            if (strlen($digitsOnly) < 6 || strlen($digitsOnly) > 15) {
                $errors['no_telepon'] = 'Nomor telepon harus terdiri dari 6–15 digit.';
            } elseif (!preg_match('/^[0-9+\(\) ]+$/', $post['no_telepon'])) {
                $errors['no_telepon'] = 'Format nomor telepon hanya boleh angka, +, (), dan spasi.';
            }
        }


        // Validasi kategori
        if (empty($post['kategori']) || !is_array($post['kategori'])) {
        $errors['kategori'] = 'Minimal harus memilih satu kategori.';
        }

        // Validasi tiket
        $tiketArr = $post['tiket'] ?? [];
        if (empty($tiketArr) || !is_array($tiketArr)) {
        $errors['tiket'] = 'Form tiket masuk harus diisi minimal satu entri.';
        } else {
        foreach ($tiketArr as $idx => $t) {
            $kat = trim($t['kategori_pengunjung'] ?? '');

                // kategori_pengunjung wajib diisi
                if ($kat === '') {
                    $errors["tiket_{$idx}_kategori_pengunjung"] = "Baris ".($idx+1).": kategori pengunjung wajib diisi.";
                }
            }
        }
        // Validasi gambar
        if (!empty($files['gambar']['name'][0])) {
            $countFiles = count($files['gambar']['name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if ($countFiles > 5) {
                $errors['gambar'] = "Maksimal 5 file gambar.";
            }
            for ($i = 0; $i < count($files['gambar']['name']); $i++) {
                $fileType = mime_content_type($files['gambar']['tmp_name'][$i]);
                if (!in_array($fileType, $allowedTypes)) {
                    $errors['gambar'] = 'Hanya file gambar (JPG, PNG, WEBP) yang diizinkan';
                    break;
                }
            }
        }

        return $errors;
    }

    private function simpanGambar($destinasiId, $files) {
        // Pastikan UPLOAD_PATH sudah didefinisikan, jika belum, definisikan di sini
        if (!defined('UPLOAD_PATH')) {
            define('UPLOAD_PATH', __DIR__ . '/../../public/assets/img/');
        }
        $uploadDir = UPLOAD_PATH . 'destinasi/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $filename = 'dest_' . $destinasiId . '_' . uniqid() . '.' . $ext;
            $target = $uploadDir . $filename;

            if (move_uploaded_file($files['tmp_name'][$i], $target)) {
                $this->galeriModel->addGambar($destinasiId, $filename);
            } else {
            // Log error jika gagal upload
            error_log("Gagal mengupload gambar: " . $files['name'][$i]);
        }
        }
        
    }

    public function edit(int $id) {
    // Mulai session jika belum
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    //--- AUTHENTICATION & AUTHORIZATION ---
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
    if (!in_array($_SESSION['role'], ['admin','superadmin'], true)) {
        header('Location: index.php?page=home');
        exit;
    }

    //--- Ambil Data Master untuk form ---
    $errors            = [];
    $destinasi         = $this->destinasiModel->getDestinasiById($id);
    if ($destinasi === null) {
        $_SESSION['error_message'] = 'Destinasi tidak ditemukan.';
        header('Location: index.php?page=destinasi');
        exit;
    }
    $kategoriList      = $this->kategoriModel->getAllKategori();
    $selectedKategori  = $this->kategoriModel->getKategoriByDestinasiId($id);
    $tiketList         = $this->tiketModel->getTiketByDestinasiId($id);
    $waktuList         = $this->waktuModel->getWaktuByDestinasiId($id);
    $gambarList        = $this->galeriModel->getGambarByDestinasiId($id);

    //--- Handle Form Submission ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = $this->validate($_POST, $_FILES);
        if (empty($errors)) {
            // Update data utama
            $this->destinasiModel->updateDestinasi($id, $_POST);
            // Update Kategori
            $this->kategoriModel->updateDestinasiKategori($id, $_POST['kategori'] ?? []);
            // Update Tiket
            if (!empty($_POST['tiket'])) {
                foreach ($_POST['tiket'] as $tiketKey => $tiketData) {
                    // Jika kunci mengandung 'new_', berarti data baru
                    if (strpos($tiketKey, 'new_') === 0) {
                        // Tambahkan tiket baru
                        $this->tiketModel->addTiket($id, $tiketData);
                    } else {
                        // Update tiket yang sudah ada
                        $this->tiketModel->updateTiket($tiketKey, $tiketData);
                    }
                }
            }
            
                        // --- PERBAIKAN: HAPUS TIKET YANG DITANDAI ---
            if (!empty($_POST['hapus_tiket'])) {
                echo "Menghapus tiket dengan ID: " . implode(', ', $_POST['hapus_tiket']) . "\n";
                
                foreach ($_POST['hapus_tiket'] as $tiketId) {
                    if ($this->tiketModel->deleteTiket($tiketId)) {
                        echo "Berhasil hapus tiket ID: $tiketId\n";
                    } else {
                        echo "Gagal hapus tiket ID: $tiketId\n";
                        $errors[] = "Gagal menghapus tiket ID: $tiketId";
                    }
                }
            }
            // --- PERBAIKAN: WAKTU OPERASIONAL ---
            // Proses waktu operasional (update yang ada dan tambah yang baru)
            if (!empty($_POST['waktu'])) {
                foreach ($_POST['waktu'] as $waktuKey => $waktuData) {
                    // Jika kunci mengandung 'new_', berarti data baru
                    if (strpos($waktuKey, 'new_') === 0) {
                        // Tambahkan waktu baru
                        $this->waktuModel->addWaktuOperasional($id, $waktuData);
                    } else {
                        // Update waktu yang sudah ada
                        $this->waktuModel->updateWaktuOperasional($waktuKey, $waktuData);
                    }
                }
            }

                        // --- PERBAIKAN: HAPUS WAKTU YANG DITANDAI ---
            if (!empty($_POST['hapus_waktu'])) {
                echo "Menghapus waktu dengan ID: " . implode(', ', $_POST['hapus_waktu']) . "\n";
                
                foreach ($_POST['hapus_waktu'] as $waktuId) {
                    if ($this->waktuModel->deleteWaktuOperasional($waktuId)) {
                        echo "Berhasil hapus waktu ID: $waktuId\n";
                    } else {
                        echo "Gagal hapus waktu ID: $waktuId\n";
                        $errors[] = "Gagal menghapus waktu operasional ID: $waktuId";
                    }
                }
            }
            // Hapus Gambar
            if (!empty($_POST['hapus_gambar'])) {
    foreach ($_POST['hapus_gambar'] as $gambarId) {
        $gambar = $this->galeriModel->getGambarByGambarId($gambarId);
        
        if ($gambar) {
        if (!defined('UPLOAD_PATH')) {
            define('UPLOAD_PATH', __DIR__ . '/../../public/assets/img/');
        }
            $filePath = UPLOAD_PATH . 'destinasi/' . $gambar['nama_file'];
            
            // Hapus file fisik
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    // Tampilkan error langsung di halaman
                    $errors[] = "Gagal menghapus file: " . $gambar['nama_file'];
                }
            } else {
                $errors[] = "File tidak ditemukan: " . $gambar['nama_file'];
            }
            
            // Hapus dari database
            if (!$this->galeriModel->deleteGambar($gambarId)) {
                $errors[] = "Gagal menghapus gambar dari database ID: $gambarId";
            }
        } else {
            $errors[] = "Gambar tidak ditemukan ID: $gambarId";
        }
    }
}
            // Tambah Gambar Baru
            if (!empty($_FILES['gambar']['name'][0])) {
                $this->simpanGambar($id, $_FILES['gambar']);
            }

            $_SESSION['success_message'] = 'Destinasi berhasil diperbarui.';
            // Redirect kembali ke edit page dengan routing yang benar
            header('Location: index.php?page=destinasi');
            exit;
        }
    }

    require_once __DIR__ . '/../views/admin/destinasi/edit.php';
}

}