<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/Database.php';

class ReportController {
    
    public function exportAppointmentsToCSV() {
        
        $role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : (isset($_SESSION['role']) ? $_SESSION['role'] : '');
        if ($role !== 'admin') {
            die("Error: Access Denied.");
        }
        
        $db = Database::getInstance()->getConnection();
        
        
        $columnsResult = $db->query("SHOW COLUMNS FROM appointments");
        $actualColumns = [];
        if ($columnsResult) {
            while ($col = $columnsResult->fetch_assoc()) {
                $actualColumns[] = $col['Field'];
            }
        }

        if (empty($actualColumns)) {
            die("Error: Table 'appointments' does not exist or has no columns.");
        }

        
        $escapedColumns = array_map(function($col) {
            return "`{$col}`";
        }, $actualColumns);
        
        $selectString = implode(', ', $escapedColumns);
        $query = "SELECT {$selectString} FROM appointments ORDER BY id DESC";
        $result = $db->query($query);
        
       
        if (ob_get_length()) {
            ob_clean();
        }
        
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=ClinicDesk_Appointments_' . date('Y-m-d') . '.csv');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        
       
        fputcsv($output, $actualColumns);
        
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                fputcsv($output, array_values($row));
            }
        }
        
        fclose($output);
        exit();
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'export') {
    $controller = new ReportController();
    $controller->exportAppointmentsToCSV();
}
?>