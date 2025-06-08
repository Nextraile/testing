<?php
// File: app/models/TiketModel.php

class TiketModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

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
    public function getTiketByDestinasiId(int $destinasiId): array {
        $sql = "SELECT * FROM tiket_masuk WHERE destinasi_id = :destinasi_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':destinasi_id', $destinasiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTiket(int $id, array $data): bool {
        $sql = "UPDATE tiket_masuk SET
                    kategori_pengunjung = :kategori_pengunjung,
                    harga_weekday       = :harga_weekday,
                    harga_weekend       = :harga_weekend,
                    keterangan          = :keterangan
                 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kategori_pengunjung', $data['kategori_pengunjung'], PDO::PARAM_STR);
        $stmt->bindValue(':harga_weekday',       $data['harga_weekday'],       PDO::PARAM_INT);
        $stmt->bindValue(':harga_weekend',       $data['harga_weekend'],       PDO::PARAM_INT);
        $stmt->bindValue(':keterangan',          $data['keterangan'],          PDO::PARAM_STR);
        $stmt->bindValue(':id',                  $id,                         PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteTiket(int $id): bool {
        $sql = "DELETE FROM tiket_masuk WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
