<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = 'discoversemarang';
$db   = 'discoversemarang';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>