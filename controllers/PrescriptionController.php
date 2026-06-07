<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

class PrescriptionController {
    public function upload() {
        Auth::requireRole('doctor');
        
        $appointment_id = (int)$_POST['appointment_id'];
        $uploadDir = __DIR__ . '/../uploads/prescriptions/';
        
        if (!is_dir($uploadDir)) {
            die("Error ..The directory is not found " . $uploadDir);
        }

        $fileInfo = pathinfo($_FILES['prescription_file']['name']);
        $ext = isset($fileInfo['extension']) ? $fileInfo['extension'] : 'pdf';
        $newName = 'presc_' . $appointment_id . '_' . time() . '.' . $ext;
        
        if (move_uploaded_file($_FILES['prescription_file']['tmp_name'], $uploadDir . $newName)) {
            
            try {
                $db = Database::getInstance()->getConnection();
                
                
                $stmt = $db->prepare("INSERT INTO prescriptions (appointment_id, file_path) VALUES (?, ?)");
                $stmt->bind_param("is", $appointment_id, $newName);
                
                if ($stmt->execute()) {
                    
                    
                    $stmt_update = $db->prepare("UPDATE appointments SET status = 'prescription_ready' WHERE id = ?");
                    $stmt_update->bind_param("i", $appointment_id);
                    $stmt_update->execute();
                    
                    echo $newName; 
                    exit();
                } else {
                    die("Error in database: " . $stmt->error);
                }
            } catch (Exception $e) {
                die("Technical Error" . $e->getMessage());
            }

        } else {
            die("The file transfer failed. Please ensure write permissions are in the folder:" . $uploadDir);
        }
    }
}


$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action == 'upload') {
    $controller = new PrescriptionController();
    $controller->upload();
} else {
    echo "Error: The action was not selected correctly.";
}
?>