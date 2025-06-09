<?php
class UlasanModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getUlasanByDestinasiId(int $destinasiId): array {
        $sql = "
            SELECT u.*, usr.username, usr.foto_profil
            FROM ulasan u
            JOIN users usr ON u.user_id = usr.id
            WHERE u.destinasi_id = :destinasi_id
            ORDER BY u.tanggal_upload DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':destinasi_id', $destinasiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahUlasan(array $data): bool {
        $sql = "
            INSERT INTO ulasan (user_id, destinasi_id, rating, isi_ulasan)
            VALUES (:user_id, :destinasi_id, :rating, :isi_ulasan)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id',       (int)$data['user_id'],       PDO::PARAM_INT);
        $stmt->bindValue(':destinasi_id',  (int)$data['destinasi_id'],  PDO::PARAM_INT);
        $stmt->bindValue(':rating',        (float)$data['rating'],      PDO::PARAM_STR);
        $stmt->bindValue(':isi_ulasan',    trim($data['isi_ulasan']),    PDO::PARAM_STR);

        return $stmt->execute();
    }
}
?>