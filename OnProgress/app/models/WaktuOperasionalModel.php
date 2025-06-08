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

    public function getWaktuByDestinasiId(int $destinasiId): array {
        $sql = "SELECT * FROM waktu_operasional WHERE destinasi_id = :destinasi_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':destinasi_id', $destinasiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateWaktuOperasional(int $id, array $data): bool {
        $sql = "UPDATE waktu_operasional SET
                    nama_hari = :nama_hari,
                    jam_buka  = :jam_buka,
                    jam_tutup = :jam_tutup,
                    keterangan= :keterangan
                 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nama_hari',  $data['nama_hari'],   PDO::PARAM_STR);
        $stmt->bindValue(':jam_buka',   $data['jam_buka'],    PDO::PARAM_STR);
        $stmt->bindValue(':jam_tutup',  $data['jam_tutup'],   PDO::PARAM_STR);
        $stmt->bindValue(':keterangan', $data['keterangan'],  PDO::PARAM_STR);
        $stmt->bindValue(':id',         $id,                   PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteWaktuOperasional(int $id): bool {
        $sql = "DELETE FROM waktu_operasional WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
