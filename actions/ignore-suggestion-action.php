<?php
session_start();
require '../inclusions/database.php';
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = $_SESSION['user_id'];
    $ignoredId = $data['ignored_id'];

    $stmt = $pdo->prepare("INSERT IGNORE INTO ignored_suggestions (user_id, ignored_user_id) VALUES (:user, :ignored)");
    $stmt->execute([
        ':user' => $userId,
        ':ignored' => $ignoredId
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>
