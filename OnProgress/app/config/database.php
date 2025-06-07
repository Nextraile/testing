<?php
// File: config/database.php

// Konfigurasi koneksi database
$host = "localhost";      // Server database
$dbname = "discoversemarang"; // Nama database
$username = "root";       // Username
$password = "";           // Password

try {
    // Buat koneksi PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set mode error: lempar exception jika ada error SQL
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set charset ke utf8mb4 (support semua karakter termasuk emoji)
    $db->exec("SET NAMES utf8mb4");
    
    // echo "Koneksi berhasil!"; // Hati-hati, jangan ditampilkan di production
} catch(PDOException $e) {
    // Tangani error koneksi
    die("Koneksi database gagal: " . $e->getMessage());
}

define('BASE_URL', '/testing/OnProgress/public/');

?>