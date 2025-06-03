<?php
class RoleSwitcherController {
    public function switch() {
        // Mulai session jika belum
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Role yang diizinkan
        $allowedRoles = ['superadmin', 'admin', 'user', 'visitor'];
        
        // Ambil role dari parameter
        $newRole = $_GET['role'] ?? '';

         // Validasi role
        if (in_array($newRole, $allowedRoles)) {
            // Set default data
            $_SESSION['role'] = $newRole;

            if ($newRole !== 'visitor') {
                // Dummy user data (simulasi login)
                $_SESSION['user_id'] = 1;
                $_SESSION['username'] = 'user';
                $_SESSION['foto_profil'] = 'default.jpg';
            } else {
                // Hapus data user jika kembali ke visitor
                session_unset();
                $_SESSION['role'] = 'visitor';
            }
            
        } else {
            // Tampilkan daftar role yang valid
            echo "Invalid role! Valid roles: " . implode(', ', $allowedRoles);
        }
        
        // Redirect ke homepage setelah 2 detik
        header("Refresh: 1; URL=index.php?page=home");
    }
}
?>