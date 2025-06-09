<?php
// File: app/models/DestinasiModel.php

class DestinasiModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getDestinasiRekomendasi(int $limit = 5): array
    {
        $sql = "
            SELECT
                d.id,
                d.nama,
                d.deskripsi_rekomendasi,
                COALESCE(AVG(u.rating), 0) AS rating,
                COALESCE(
                  GROUP_CONCAT(DISTINCT k.nama_kategori 
                               ORDER BY k.nama_kategori SEPARATOR ', '),
                  ''
                ) AS kategori,
                -- ambil hanya nama_file pertama dari galeri
                COALESCE(
                  SUBSTRING_INDEX(
                    GROUP_CONCAT(g.nama_file ORDER BY g.id SEPARATOR ','), 
                    ',', 
                    1
                  ),
                  ''
                ) AS gambar
            FROM destinasi d
            LEFT JOIN ulasan u 
                ON d.id = u.destinasi_id
            LEFT JOIN destinasi_kategori dk 
                ON d.id = dk.destinasi_id
            LEFT JOIN kategori k 
                ON dk.kategori_id = k.id
            LEFT JOIN galeri g 
                ON d.id = g.destinasi_id
            GROUP BY d.id
            ORDER BY rating DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cariDestinasi(string $keyword): array
    {
        $sql = "
            SELECT 
                d.id, 
                d.nama,
                COALESCE(AVG(u.rating), 0) AS rating
            FROM destinasi d
            LEFT JOIN ulasan u ON d.id = u.destinasi_id
            WHERE d.nama LIKE :kw
            GROUP BY d.id
            ORDER BY d.nama ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addDestinasi(array $d): int|false
    {
        $sql = "
            INSERT INTO destinasi 
                (nama, deskripsi, deskripsi_rekomendasi, alamat, no_telepon, facebook, instagram, gmaps_link)
            VALUES
                (:nama, :deskripsi, :deskripsi_rekomendasi, :alamat, :no_telepon, :facebook, :instagram, :gmaps_link)
        ";
        $stmt = $this->db->prepare($sql);

        $params = [
            ':nama' => $d['nama'],
            ':deskripsi' => $d['deskripsi'],
            ':deskripsi_rekomendasi' => $d['deskripsi_rekomendasi'] ?? '',
            ':alamat' => $d['alamat'],
            ':no_telepon' => $d['no_telepon'] ?? null,
            ':facebook' => $d['facebook'] ?? null,
            ':instagram' => $d['instagram'] ?? null,
            ':gmaps_link' => $d['gmaps_link'],
        ];

        if ($stmt->execute($params)) {
            return (int) $this->db->lastInsertId();
        }

        return false;
    }

    public function getAllDestinasi(int $limit, int $offset, string $search = ''): array
    {
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

    public function countAllDestinasi(string $search = ''): int
    {
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
        return (int) $stmt->fetchColumn();
    }

    public function deleteDestinasi(int $id): bool
    {
        try {
            $this->db->beginTransaction();

            // Hapus child-table
            foreach (['destinasi_kategori', 'galeri', 'tiket_masuk', 'waktu_operasional', 'ulasan'] as $table) {
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

    public function getDestinasiById(int $id): ?array
    {
        $sql = "
        SELECT
            d.*,
            COALESCE(AVG(u.rating), 0)      AS rating,
            COUNT(u.id)                     AS jumlah_ulasan
        FROM destinasi d
        LEFT JOIN ulasan u ON d.id = u.destinasi_id
        WHERE d.id = :id
        GROUP BY d.id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function updateDestinasi(int $id, array $data): bool
    {
        $sql = "UPDATE destinasi SET
                    nama                   = :nama,
                    deskripsi              = :deskripsi,
                    deskripsi_rekomendasi  = :deskripsi_rekomendasi,
                    alamat                 = :alamat,
                    no_telepon             = :no_telepon,
                    facebook               = :facebook,
                    instagram              = :instagram,
                    gmaps_link             = :gmaps_link
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nama', $data['nama'], PDO::PARAM_STR);
        $stmt->bindValue(':deskripsi', $data['deskripsi'], PDO::PARAM_STR);
        $stmt->bindValue(':deskripsi_rekomendasi', $data['deskripsi_rekomendasi'], PDO::PARAM_STR);
        $stmt->bindValue(':alamat', $data['alamat'], PDO::PARAM_STR);
        $stmt->bindValue(':no_telepon', $data['no_telepon'], PDO::PARAM_STR);
        $stmt->bindValue(':facebook', $data['facebook'], PDO::PARAM_STR);
        $stmt->bindValue(':instagram', $data['instagram'], PDO::PARAM_STR);
        $stmt->bindValue(':gmaps_link', $data['gmaps_link'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getDestinasi(string $keyword = '', array $kategoriIds = [], int $limit = 12, int $offset = 0): array
    {
        // Pastikan offset tidak negatif
        $offset = max(0, $offset);

        $sql = "
            SELECT
                d.id,
                d.nama,
                d.deskripsi,
                (
                    SELECT g.nama_file
                    FROM galeri g
                    WHERE g.destinasi_id = d.id
                    ORDER BY g.id
                    LIMIT 1
                ) AS gambar,
                COALESCE(
                    GROUP_CONCAT(DISTINCT k.nama_kategori SEPARATOR ', '),
                    ''
                ) AS kategori,
                COALESCE(AVG(u.rating), 0) AS rating,
                COUNT(u.id) AS jumlah_ulasan
            FROM destinasi d
            LEFT JOIN destinasi_kategori dk ON d.id = dk.destinasi_id
            LEFT JOIN kategori k ON dk.kategori_id = k.id
            LEFT JOIN ulasan u ON d.id = u.destinasi_id
        ";

        $conditions = [];
        $params = [];

        if ($keyword !== '') {
            $conditions[] = 'd.nama LIKE :kw';
            $params[':kw'] = "%{$keyword}%";
        }

        if (!empty($kategoriIds)) {
            $placeholders = [];
            foreach ($kategoriIds as $i => $id) {
                $ph = ":cat{$i}";
                $placeholders[] = $ph;
                $params[$ph] = (int) $id;
            }
            $conditions[] = 'dk.kategori_id IN (' . implode(', ', $placeholders) . ')';
        }

        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        if (!empty($kategoriIds)) {
            $sql .= ' GROUP BY d.id HAVING COUNT(DISTINCT dk.kategori_id) = ' . count($kategoriIds);
        } else {
            $sql .= ' GROUP BY d.id';
        }

        $sql .= ' ORDER BY d.nama ASC LIMIT :limit OFFSET :offset';

        $stmt = $this->db->prepare($sql);

        // Bind params dinamis
        if ($keyword !== '') {
            $stmt->bindValue(':kw', $params[':kw'], PDO::PARAM_STR);
        }
        if (!empty($kategoriIds)) {
            foreach ($kategoriIds as $i => $id) {
                $stmt->bindValue(":cat{$i}", (int) $id, PDO::PARAM_INT);
            }
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Hitung total destinasi sesuai filter.
     *
     * @param string $keyword
     * @param int[]  $kategoriIds
     * @return int
     */
    public function countDestinasi(string $keyword = '', array $kategoriIds = []): int
    {
        $sql = "
            SELECT COUNT(DISTINCT d.id) AS total
            FROM destinasi d
            LEFT JOIN destinasi_kategori dk ON d.id = dk.destinasi_id
            LEFT JOIN kategori k ON dk.kategori_id = k.id
        ";

        $conditions = [];
        $params = [];

        if ($keyword !== '') {
            $conditions[] = 'd.nama LIKE :kw';
            $params[':kw'] = "%{$keyword}%";
        }

        if (!empty($kategoriIds)) {
            $placeholders = [];
            foreach ($kategoriIds as $i => $id) {
                $ph = ":cat{$i}";
                $placeholders[] = $ph;
                $params[$ph] = (int) $id;
            }
            $conditions[] = 'dk.kategori_id IN (' . implode(', ', $placeholders) . ')';
        }

        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $val, $type);
        }
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['total'] ?? 0);
    }

    /**
     * Ambil semua kategori.
     *
     * @return array
     */
    public function getAllKategori(): array
    {
        $stmt = $this->db->query('SELECT id, nama_kategori FROM kategori');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
