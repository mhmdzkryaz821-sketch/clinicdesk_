<?php
// models/UserModel.php
require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel {

    public function countAll() {
        $sql = "SELECT COUNT(*) AS total FROM users";
        $result = $this->execute($sql)->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function getAllPaginated($limit, $offset) {
        $sql = "SELECT id, name, email, role, status FROM users ORDER BY id DESC LIMIT ? OFFSET ?";
        return $this->execute($sql, "ii", [$limit, $offset])->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function toggleActive($id) {
        
        $sql = "SELECT status FROM users WHERE id = ?";
        $user = $this->execute($sql, "i", [$id])->get_result()->fetch_assoc();
        if ($user) {
            $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
            $updateSql = "UPDATE users SET status = ? WHERE id = ?";
            $this->execute($updateSql, "si", [$newStatus, $id]);
            return $newStatus;
        }
        return false;
    }

    public function updatePassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        return $this->execute($sql, "si", [$hashed, $id]);
    }
}