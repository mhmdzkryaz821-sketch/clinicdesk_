<?php
// models/PrescriptionModel.php
require_once __DIR__ . '/BaseModel.php';

class PrescriptionModel extends BaseModel {

   
    public function create($appointment_id, $patient_id, $doctor_id, $instructions, $file_path = null) {
        $sql = "INSERT INTO prescriptions (appointment_id, patient_id, doctor_id, instructions, file_path) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiiss", $appointment_id, $patient_id, $doctor_id, $instructions, $file_path);
        return $stmt->execute();
    }

    public function findById($id) {
        $sql = "SELECT * FROM prescriptions WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getByPatient($patient_id) {
        $sql = "SELECT p.*, u.name as doctor_name 
                FROM prescriptions p
                JOIN users u ON p.doctor_id = u.id
                WHERE p.patient_id = ?
                ORDER BY p.created_at DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}