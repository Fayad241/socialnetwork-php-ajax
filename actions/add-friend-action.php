<?php
session_start();
require '../inclusions/database.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Méthode non autorisée");
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $senderId = $_SESSION['user-id'];
    $receiverId = $data['receiver_id'];

    if (!$receiverId || $receiverId == $senderId) {
        throw new Exception("Identifiant invalide.");
    }

    // Vérifie s'il existe déjà une invitation
    $check = $pdo->prepare("SELECT * FROM friend_requests WHERE sender_id = :sender AND receiver_id = :receiver AND status = 'pending'");
    $check->execute([
        ':sender' => $senderId,
        ':receiver' => $receiverId
    ]);
    if ($check->rowCount() > 0) {
        throw new Exception("Invitation déjà envoyée.");
    }

    // Insertion dans friend_requests
    $stmt = $pdo->prepare("INSERT INTO friend_requests (sender_id, receiver_id) VALUES (:sender, :receiver)");
    $stmt->execute([
        ':sender' => $senderId,
        ':receiver' => $receiverId
    ]);

    // Notifications pour le destinataire
    $notif = $pdo->prepare("INSERT INTO notifications (user_id, type, message) VALUES (:user, 'friend_request', :msg)");
    $notif->execute([
        ':user' => $receiverId,
        ':msg' => 'Vous avez reçu une invitation d\'ami.'
    ]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
