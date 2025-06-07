<?php
// File: app/models/TiketModel.php

class TiketModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Tambah satu entri tiket.
     *
     * @param int   $destinasiId  ID destinasi
     * @param array $data         Array dengan kunci:
     *                            'kategori_pengunjung', 'harga_weekday', 'harga_weekend', 'keterangan'
     * @return bool               true jika berhasil, false jika gagal
     */
    public function addTiket(int $destinasiId, array $data): bool {
        // Query dengan placeholder posisi (?)
        $sql = "
            INSERT INTO tiket_masuk 
                (destinasi_id, kategori_pengunjung, harga_weekday, harga_weekend, keterangan)
            VALUES 
                (?, ?, ?, ?, ?)
        ";
        $stmt = $this->db->prepare($sql);

        // Eksekusi langsung dengan array yang sesuai urutan placeholder
        return $stmt->execute([
            $destinasiId,
            $data['kategori_pengunjung'],
            $data['harga_weekday']  ?? null,
            $data['harga_weekend']  ?? null,
            $data['keterangan']     ?? '',
        ]);
    }
}
