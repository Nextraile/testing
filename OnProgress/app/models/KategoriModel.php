<?php
// File: app/models/KategoriModel.php

class KategoriModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Ambil semua kategori dari tabel 'kategori'
     * Mengembalikan array of associative arrays [{id, nama_kategori}, …]
     */
    public function getAllKategori(): array {
        $sql = "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori";
        $stmt = $this->db->query($sql);
        // fetchAll(PDO::FETCH_ASSOC) mengembalikan semua baris sebagai array asosiatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Simpan relasi destinasi-kategori (banyak ke banyak).
     * Menerima $destinasiId (int) dan array $kategoriIds (tipe int atau numeric).
     */
    public function linkDestinasiKategori(int $destinasiId, array $kategoriIds): void {
        if (empty($kategoriIds)) {
            return;
        }

        $sql = "INSERT INTO destinasi_kategori (destinasi_id, kategori_id) VALUES (:dest, :kat)";
        $stmt = $this->db->prepare($sql);

        foreach ($kategoriIds as $kat) {
            $kategoriId = (int)$kat;
            $stmt->execute([
                ':dest' => $destinasiId,
                ':kat'  => $kategoriId,
            ]);
        }
    }
}
