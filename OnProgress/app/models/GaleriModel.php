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
}
