<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=app_db;charset=utf8mb4", "root", "");
    
    // Fetch all data from target_table
    $stmt = $pdo->query("SELECT id, original_id, info FROM target_table");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>