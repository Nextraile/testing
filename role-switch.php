<?php
require_once 'includes/session.php';
$allowed = ['visitor', 'user', 'admin', 'superadmin'];
if (isset($_GET['role']) && in_array($_GET['role'], $allowed)) {
    $_SESSION['role'] = $_GET['role'];
    $role = $_SESSION['role'];
    if ($role === 'visitor') {
        session_unset(); // Kosongkan semua variabel session
        session_destroy(); // Hapus session sepenuhnya
}}
header('Location: index.php');
exit;
?>