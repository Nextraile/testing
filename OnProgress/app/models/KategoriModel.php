<?php
// File: app/models/KategoriModel.php

class KategoriModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllKategori(): array {
        $sql = "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori";
        $stmt = $this->db->query($sql);
        // fetchAll(PDO::FETCH_ASSOC) mengembalikan semua baris sebagai array asosiatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function getKategoriByDestinasiId(int $destinasiId): array {
        $sql  = "SELECT kategori_id FROM destinasi_kategori WHERE destinasi_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $destinasiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function updateDestinasiKategori(int $destinasiId, array $kategoriIds): bool {
        try {
            $this->db->beginTransaction();

            // Hapus relasi lama
            $del = $this->db->prepare(
                "DELETE FROM destinasi_kategori WHERE destinasi_id = :id"
            );
            $del->bindValue(':id', $destinasiId, PDO::PARAM_INT);
            $del->execute();

            // Siapkan statement insert
            $ins = $this->db->prepare(
                "INSERT INTO destinasi_kategori (destinasi_id, kategori_id)
                 VALUES (:destinasi_id, :kategori_id)"
            );
            foreach ($kategoriIds as $katId) {
                $ins->bindValue(':destinasi_id', $destinasiId, PDO::PARAM_INT);
                $ins->bindValue(':kategori_id',  (int)$katId,       PDO::PARAM_INT);
                $ins->execute();
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
