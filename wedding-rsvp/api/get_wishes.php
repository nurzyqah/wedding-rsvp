<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    // Get total count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM wishes WHERE is_approved = 1");
    $total = $stmt->fetch()['total'];
    
    // Get wishes
    $stmt = $pdo->prepare("
        SELECT *, DATE_FORMAT(created_at, '%d %b, %H:%i') as formatted_date 
        FROM wishes 
        WHERE is_approved = 1 
        ORDER BY created_at DESC 
        LIMIT :limit OFFSET :offset
    ");
    
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $wishes = $stmt->fetchAll();
    
    $response = [
        'success' => true,
        'wishes' => $wishes,
        'total' => $total,
        'page' => $page,
        'pages' => ceil($total / $limit)
    ];
    
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ];
}

echo json_encode($response);
?>