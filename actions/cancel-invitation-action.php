<?php
session_start();
require '../inclusions/database.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Méthode non autorisée.");
    }

    $data = json_decode(file_get_contents("php://input"), true);
    // $senderId = $_SESSION['user_id'];
    $receiverId = $data['receiver_id'];

    if (!$receiverId || $receiverId === $_SESSION['user_id']) {
        throw new Exception("ID invalide.");
    }

    // Supprimer l'invitation dans friend_requests
    $delete = $pdo->prepare("DELETE FROM friend_requests WHERE `sender-id` = :sender AND `receiver-id` = :receiver AND status = 'pending'");
    $delete->execute([
        ':sender' => $_SESSION['user_id'],
        ':receiver' => $receiverId
    ]);

    // Supprimer les notifications associées
    $notif = $pdo->prepare("DELETE FROM notifications WHERE `user-id` = :receiver AND type = 'friend_request'");
    $notif->execute([
        ':receiver' => $receiverId
    ]);

    echo json_encode([
        'success' => true,
        'receiver_id' => $receiverId 
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}