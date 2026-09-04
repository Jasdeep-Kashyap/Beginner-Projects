<?php
header('Content-Type: application/json');

// Database credentials
$host = 'localhost';
$db   = 'app_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Fetch data from the first table
    $stmt = $pdo->query("SELECT id, user_data FROM source_table LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // 2. Insert that data into the second table
        $insertStmt = $pdo->prepare("INSERT INTO target_table (original_id, info) VALUES (?, ?)");
        $insertStmt->execute([$row['id'], $row['user_data']]);

        // 3. Send success response back to JS
        echo json_encode([
            "status" => "success", 
            "message" => "Successfully transferred data: " . $row['user_data']
        ]);
    } else {
        echo json_encode(["status" => "empty", "message" => "No data available to move."]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>