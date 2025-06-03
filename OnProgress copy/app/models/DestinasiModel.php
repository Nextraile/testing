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
    
    // Tambahkan method baru untuk pagination
    public function getAllPaginated($limit, $offset) {
        // Query dengan limit dan offset untuk pagination
        $stmt = $this->db->prepare("SELECT * FROM destinasi ORDER BY tanggal_dibuat DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method untuk mendapatkan total destinasi
    public function getTotal() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM destinasi");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Method untuk mendapatkan gambar utama (jika diperlukan)
    public function getGambarUtama($destinasi_id) {
        $stmt = $this->db->prepare("SELECT nama_file FROM galeri WHERE destinasi_id = :id LIMIT 1");
        $stmt->bindParam(':id', $destinasi_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nama_file'] : null;
    }

    public function search($keyword, $limit, $offset) {
    $stmt = $this->db->prepare("
        SELECT * 
        FROM destinasi 
        WHERE nama LIKE :keyword 
           OR alamat LIKE :keyword 
           OR deskripsi LIKE :keyword 
        ORDER BY tanggal_dibuat DESC 
        LIMIT :limit OFFSET :offset
    ");
    
    $searchKeyword = "%$keyword%";
    $stmt->bindValue(':keyword', $searchKeyword, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getSearchTotal($keyword) {
    $stmt = $this->db->prepare("
        SELECT COUNT(*) as total 
        FROM destinasi 
        WHERE nama LIKE :keyword 
           OR alamat LIKE :keyword 
           OR deskripsi LIKE :keyword
    ");
    
    $searchKeyword = "%$keyword%";
    $stmt->bindValue(':keyword', $searchKeyword, PDO::PARAM_STR);
    
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
}
?>