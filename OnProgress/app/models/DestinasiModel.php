<?php
// File: app/models/DestinasiModel.php

class DestinasiModel
{
    private $db;

    // Constructor: menerima koneksi database
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addNewDestinasi(
        //destinasi
        $nama,
        $deskripsi,
        $deskripsi_rekomendasi,
        $alamat,
        $no_telepon,
        $facebook,
        $instagram,
        $gmaps_link,
        //gambar
        $nama_file,
        //kategori
        $kategori_id,
        $nama_kategori,
        //tiket_masuk
        $kategori_pengunjung,
        $harga_weekday,
        $harga_weekend,
        $keterangan_tiket,
        //waktu_operasional
        $nama_hari,
        $jam_buka,
        $jam_tutup,
        $keterangan_waktu_operasional
        )
    {
        //insert destinasi
        // Gunakan prepared statement untuk keamanan
        $stmt1 = $this->db->prepare("INSERT INTO destinasi
        (
        nama,
        deskripsi,
        deskripsi_rekomendasi,
        alamat,
        no_telepon,
        facebook,
        instagram,
        gmaps_link
        )
        VALUES (
        :nama,
        :deskripsi,
        :deskripsi_rekomendasi,
        :alamat,
        :no_telepon,
        :facebook,
        :instagram,
        :gmaps_link
        )");

        $stmt1->bindParam(':nama', $nama);
        $stmt1->bindParam(':deskripsi', $deskripsi);
        $stmt1->bindParam(':deskripsi_rekomendasi', $deskripsi_rekomendasi);
        $stmt1->bindParam(':alamat', $alamat);
        $stmt1->bindParam(':no_telepon', $no_telepon);
        $stmt1->bindParam(':facebook', $facebook);
        $stmt1->bindParam(':instagram', $instagram);
        $stmt1->bindParam(':gmaps_link', $gmaps_link);
        $stmt1->execute();

        $success = $stmt1->execute();
        if (!$success) return false;
        $destinasi_id = $this->db->lastInsertId();


        //insert galeri
        $stmt2 = $this->db->prepare("INSERT INTO galeri
        (
        destinasi_id,
        nama_file
        )
        VALUES (
        :destinasi_id,
        :nama_file
        )");

        $stmt2->bindParam(':destinasi_id', $destinasi_id);
        $stmt2->bindParam(':nama_file', $nama_file);
        $stmt2->execute();

        //insert kategori
        $stmt3 = $this->db->prepare("INSERT INTO kategori
        (
        nama_kategori
        )
        VALUES (
        :nama_kategori
        )");

        $stmt3->bindParam(':nama_kategori', $nama_kategori);
        $stmt3->execute();

        //insert destinasi_kategori
        $stmt4 = $this->db->prepare("INSERT INTO destinasi_kategori
        (
        destinasi_id,
        kategori_id
        )
        VALUES (
        :destinasi_id,
        :kategori_id
        )");

        $stmt4->bindParam(':destinasi_id', $destinasi_id);
        $stmt4->bindParam(':kategori_id', $kategori_id);
        $stmt4->execute();

        //insert tiket_masuk
        $stmt5 = $this->db->prepare("INSERT INTO tiket_masuk
        (
        destinasi_id,
        kategori_pengunjung,
        harga_weekday,
        harga_weekend,
        keterangan
        )
        VALUES (
        :destinasi_id,
        :kategori_pengunjung,
        :harga_weekday,
        :harga_weekend,
        :keterangan
        )");
        $stmt5->bindParam(':destinasi_id', $destinasi_id);
        $stmt5->bindParam(':kategori_pengunjung', $kategori_pengunjung);
        $stmt5->bindParam(':harga_weekday', $harga_weekday);
        $stmt5->bindParam(':harga_weekend', $harga_weekend);
        $stmt5->bindParam(':keterangan', $keterangan_tiket);
        $stmt5->execute();

        //insert waktu_operasional
        $stmt6 = $this->db->prepare("INSERT INTO waktu_operasional
        (
        destinasi_id,
        nama_hari,
        jam_buka,
        jam_tutup,
        keterangan
        )
        VALUES (
        :destinasi_id,
        :nama_hari,
        :jam_buka,
        :jam_tutup,
        :keterangan
        )");
        $stmt6->bindParam(':destinasi_id', $destinasi_id);
        $stmt6->bindParam(':nama_hari', $nama_hari);
        $stmt6->bindParam(':jam_buka', $jam_buka);
        $stmt6->bindParam(':jam_tutup', $jam_tutup);
        $stmt6->bindParam(':keterangan', $keterangan_waktu_operasional);
        $stmt6->execute();
    }

    // Ambil semua destinasi untuk homepage
    public function getDestinasiTableAdmin()
    {
        // Query database
        $stmt = $this->db-> query("SELECT 
        d.id,
        d.nama,
        k.nama_kategori,
        r.rata_rating
        FROM destinasi d
        LEFT JOIN (
            SELECT 
                destinasi_id,
                ROUND(AVG(rating), 1) AS rata_rating
            FROM ulasan
            GROUP BY destinasi_id
        ) r ON d.id = r.destinasi_id
        LEFT JOIN (
            SELECT 
                dk.destinasi_id,
                GROUP_CONCAT(DISTINCT k.nama_kategori SEPARATOR ', ') AS kategori
            FROM destinasi_kategori dk
            JOIN kategori k ON dk.kategori_id = k.id
            GROUP BY dk.destinasi_id
        ) k ON d.id = k.destinasi_id;
        ");
        // nama, kategori, rating
        // Kembalikan hasil sebagai array asosiatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil detail destinasi berdasarkan ID
//     public function getById($id)
//     {
//         // Gunakan prepared statement untuk keamanan
//         $stmt = $this->db->prepare("SELECT * FROM destinasi WHERE id = :id");
//         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//         $stmt->execute();

//         // Kembalikan satu baris hasil
//         return $stmt->fetch(PDO::FETCH_ASSOC);
//     }
}
