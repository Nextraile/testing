<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByEmailAndUsername($email, $username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function usernameExists($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    public function createUser($username, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password_hash, role, tanggal_register)
            VALUES (:username, :email, :password_hash, 'user', NOW())
        ");
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $passwordHash);
        
        return $stmt->execute() ? $this->db->lastInsertId() : false;
    }

        public function isUsernameEmailMatch($username, $email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username AND email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

        public function getByUsernameEmail($username, $email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data) {
        $setParts = [];
        $params = [':id' => $id];
        
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        
        $setClause = implode(', ', $setParts);
        
        $query = "UPDATE users SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute($params);
    }

    public function getAllUsers(int $limit, int $offset, string $search = ''): array {
        $sql = "SELECT id, username, email, role, tanggal_register
                FROM users";
        
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE username LIKE :search OR email LIKE :search";
            $params[':search'] = "%{$search}%";
        }

        $sql .= " ORDER BY id DESC
                  LIMIT :limit
                  OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        // Bind pagination sebagai integer
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Bind search jika ada
        if (isset($params[':search'])) {
            $stmt->bindValue(':search', $params[':search'], PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllUsers(string $search = ''): int {
        $sql = "SELECT COUNT(*) AS total FROM users";
        
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE username LIKE :search OR email LIKE :search";
            $params[':search'] = "%{$search}%";
        }

        $stmt = $this->db->prepare($sql);

        if (isset($params[':search'])) {
            $stmt->bindValue(':search', $params[':search'], PDO::PARAM_STR);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($row['total'] ?? 0);
    }

    public function updateUserRole(int $userId, string $newRole): bool {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':role', $newRole, PDO::PARAM_STR);
        $stmt->bindValue(':id',   $userId,  PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>