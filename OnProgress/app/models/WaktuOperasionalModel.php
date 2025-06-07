<?php
// File: app/models/WaktuOperasionalModel.php

class WaktuOperasionalModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addWaktuOperasional(int $destinasiId, array $data): bool {
        // Query dengan placeholder posisi (?)
        $sql = "
            INSERT INTO waktu_operasional
                (destinasi_id, nama_hari, jam_buka, jam_tutup, keterangan)
            VALUES
                (?, ?, ?, ?, ?)
        ";
        $stmt = $this->db->prepare($sql);

        // Eksekusi langsung dengan array sesuai urutan placeholder
        return $stmt->execute([
            $destinasiId,
            $data['nama_hari'],
            $data['jam_buka']   ?? null,
            $data['jam_tutup']  ?? null,
            $data['keterangan'] ?? '',
        ]);
    }
}
