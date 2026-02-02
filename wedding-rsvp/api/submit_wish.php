<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $side = filter_input(INPUT_POST, 'side', FILTER_SANITIZE_STRING);
    $relationship = filter_input(INPUT_POST, 'relationship', FILTER_SANITIZE_STRING);
    $attendance = filter_input(INPUT_POST, 'attendance', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    // Validate
    if (empty($name) || empty($message) || empty($side)) {
        $response['message'] = 'Sila isi semua maklumat yang diperlukan.';
        echo json_encode($response);
        exit;
    }
    
    // Get IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Insert into database
    try {
        $stmt = $pdo->prepare("
            INSERT INTO wishes (name, side, relationship, attendance, message, ip_address) 
            VALUES (:name, :side, :relationship, :attendance, :message, :ip)
        ");
        
        $stmt->execute([
            ':name' => $name,
            ':side' => $side,
            ':relationship' => $relationship,
            ':attendance' => $attendance,
            ':message' => $message,
            ':ip' => $ip_address
        ]);
        
        $response['success'] = true;
        $response['message'] = 'Wish berjaya dihantar!';
        $response['wish_id'] = $pdo->lastInsertId();
        
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>