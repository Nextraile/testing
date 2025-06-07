<?php
// File: app/models/DestinasiModel.php

class DestinasiModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addDestinasi(array $d): int|false {
        $sql = "
            INSERT INTO destinasi 
                (nama, deskripsi, deskripsi_rekomendasi, alamat, no_telepon, facebook, instagram, gmaps_link)
            VALUES
                (:nama, :deskripsi, :deskripsi_rekomendasi, :alamat, :no_telepon, :facebook, :instagram, :gmaps_link)
        ";
        $stmt = $this->db->prepare($sql);

        $params = [
            ':nama'                  => $d['nama'],
            ':deskripsi'             => $d['deskripsi'],
            ':deskripsi_rekomendasi' => $d['deskripsi_rekomendasi'] ?? '',
            ':alamat'                => $d['alamat'],
            ':no_telepon'            => $d['no_telepon'] ?? null,
            ':facebook'              => $d['facebook'] ?? null,
            ':instagram'             => $d['instagram'] ?? null,
            ':gmaps_link'            => $d['gmaps_link'],
        ];

        if ($stmt->execute($params)) {
            return (int)$this->db->lastInsertId();
        }

        return false;
    }

    public function getAllDestinasi(int $limit, int $offset, string $search = ''): array {
        $sql = "
          SELECT d.id, d.nama,
                 GROUP_CONCAT(k.nama_kategori SEPARATOR ', ') AS kategori,
                 AVG(u.rating) AS rating
          FROM destinasi d
          LEFT JOIN destinasi_kategori dk ON d.id = dk.destinasi_id
          LEFT JOIN kategori k             ON dk.kategori_id = k.id
          LEFT JOIN ulasan u               ON d.id = u.destinasi_id
        ";

        $params = [];
        if ($search !== '') {
            $sql .= " WHERE d.nama LIKE :s OR k.nama_kategori LIKE :s ";
            $params[':s'] = "%{$search}%";
        }

        $sql .= " GROUP BY d.id
                  ORDER BY d.id DESC
                  LIMIT :lim OFFSET :off";

        $stmt = $this->db->prepare($sql);
        // Bind pencarian
        if (isset($params[':s'])) {
            $stmt->bindValue(':s', $params[':s'], PDO::PARAM_STR);
        }
        // Bind limit/offset sebagai integer
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllDestinasi(string $search = ''): int {
        $sql = "
          SELECT COUNT(DISTINCT d.id) AS total
          FROM destinasi d
          LEFT JOIN destinasi_kategori dk ON d.id = dk.destinasi_id
          LEFT JOIN kategori k             ON dk.kategori_id = k.id
        ";
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE d.nama LIKE :s OR k.nama_kategori LIKE :s";
            $params[':s'] = "%{$search}%";
        }

        $stmt = $this->db->prepare($sql);
        if (isset($params[':s'])) {
            $stmt->bindValue(':s', $params[':s'], PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function deleteDestinasi(int $id): bool {
        try {
            $this->db->beginTransaction();

            // Hapus child-table
            foreach (['destinasi_kategori','galeri','tiket_masuk','waktu_operasional','ulasan'] as $table) {
                $stmt = $this->db->prepare(
                    "DELETE FROM {$table} WHERE destinasi_id = :id"
                );
                $stmt->execute([':id' => $id]);
            }

            // Hapus utama
            $stmt = $this->db->prepare(
                "DELETE FROM destinasi WHERE id = :id"
            );
            $stmt->execute([':id' => $id]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
}
