<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/AppointmentModel.php';

class AppointmentController {

    public function book() {
        Auth::requireRole('patient');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !CSRF::verifyToken($_POST['csrf_token'])) {
                $_SESSION['error'] = "Invalid CSRF token.";
                header('Location: ' . BASE_URL . 'views/appointments/book.php');
                exit();
            }

            $patient_id = Auth::user('user_id');
            $doctor_id = (int)$_POST['doctor_id'];
            $appt_date = $_POST['appt_date']; 
            $appt_time = $_POST['appt_time']; 
            $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);

            $appointmentModel = new AppointmentModel();
            
            
            if ($appointmentModel->create($patient_id, $doctor_id, $appt_date, $appt_time, $notes)) {
                $_SESSION['success'] = "Appointment booked successfully!";
            } else {
                $_SESSION['error'] = "Failed to book appointment.";
            }

            header('Location: ' . BASE_URL . 'views/dashboard/patient.php');
            exit();
        }
    }

   public function updateStatus() {
    Auth::requireRole('doctor');

    $appointment_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
    
   
    if ($status === 'cancelled') {
        $status = 'canceled'; 
    }

    $doctor_id = Auth::user('user_id'); 

    if ($appointment_id && in_array($status, ['confirmed', 'canceled', 'completed'])) {
        $appointmentModel = new AppointmentModel();
        $appointmentModel->updateStatusSecure($appointment_id, $status, $doctor_id);
    }
    header('Location: ' . BASE_URL . 'views/dashboard/doctor.php');
    exit();
}
} 

$action = $_GET['action'] ?? '';
$controller = new AppointmentController();

if ($action === 'book') {
    $controller->book();
} elseif ($action === 'update') {
    $controller->updateStatus();
}