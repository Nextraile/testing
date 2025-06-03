<?php
// File: app/models/DestinasiModel.php

class DestinasiModel {
    private $db;

    // Constructor: menerima koneksi database
    public function __construct($db) {
        $this->db = $db;
    }

    // Ambil semua destinasi untuk homepage
    public function getAll() {
        // Query database
        $stmt = $this->db->query("SELECT * FROM destinasi ORDER BY tanggal_dibuat DESC");
        
        // Kembalikan hasil sebagai array asosiatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil detail destinasi berdasarkan ID
    public function getById($id) {
        // Gunakan prepared statement untuk keamanan
        $stmt = $this->db->prepare("SELECT * FROM destinasi WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Kembalikan satu baris hasil
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>