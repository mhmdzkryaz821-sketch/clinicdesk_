<?php

require_once __DIR__ . '/BaseModel.php';

class DoctorModel extends BaseModel {

    public function findByUserId($userId) {
        $sql = "SELECT d.*, u.name, u.email, u.status 
                FROM doctors d 
                JOIN users u ON d.user_id = u.id 
                WHERE d.user_id = ?";
        return $this->execute($sql, "i", [$userId])->get_result()->fetch_assoc();
    }

    public function update($userId, $specializationId, $fee, $bio) {
        $sql = "UPDATE doctors SET specialization_id = ?, consultation_fee = ?, bio = ? WHERE user_id = ?";
        return $this->execute($sql, "idsi", [$specializationId, $fee, $bio, $userId]);
    }

    public function getAvailableDays($doctorId) {
        
        $sql = "SELECT available_days FROM doctors WHERE id = ?";
        $result = $this->execute($sql, "i", [$doctorId])->get_result()->fetch_assoc();
        return $result ? explode(',', $result['available_days']) : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    }
}