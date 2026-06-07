<?php

require_once __DIR__ . '/BaseModel.php';

class AppointmentModel extends BaseModel {

    
public function create($patient_id, $doctor_id, $appt_date, $appt_time, $notes) {
    $db = Database::getInstance()->getConnection();
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appt_date, appt_time, notes, status) 
            VALUES (?, ?, ?, ?, ?, 'pending')";
    
    $stmt = $db->prepare($sql);
  
$stmt->bind_param("iisss", $patient_id, $doctor_id, $appt_date, $appt_time, $notes);
    return $stmt->execute();
}

   
public function getByDoctor($doctor_id) {
   
    $sql = "SELECT a.*, u.name as patient_name 
            FROM appointments a
            JOIN users u ON a.patient_id = u.id
            WHERE a.doctor_id = ?
            ORDER BY a.appt_date ASC"; 

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function isSlotBooked($doctor_id, $appt_date, $appt_time) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT id FROM appointments WHERE doctor_id = ? AND appt_date = ? AND appt_time = ?");
    $stmt->bind_param("iss", $doctor_id, $appt_date, $appt_time);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

  
   public function updateStatusSecure($id, $status, $doctor_id) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("UPDATE appointments SET status = ? WHERE id = ? AND doctor_id = ?");
        $stmt->bind_param("sii", $status, $id, $doctor_id);
        $stmt->execute();
        
        return $stmt->affected_rows > 0;
    }
}