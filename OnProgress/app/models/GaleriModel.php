<?php
// File: app/models/GaleriModel.php

class GaleriModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addGambar(int $destinasiId, string $filename): bool {
        // 1) Menggunakan placeholder terurut (?)
        $sql = "INSERT INTO galeri (destinasi_id, nama_file) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$destinasiId, $filename]);
    }

    public function getGambarByDestinasiId(int $destinasiId): array {
        $sql = "SELECT * FROM galeri WHERE destinasi_id = :destinasi_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':destinasi_id', $destinasiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGambarByGambarId(int $gambarId): array {
        $sql = "SELECT * FROM galeri WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $gambarId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteGambar(int $id): bool {
        $sql = "DELETE FROM galeri WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
