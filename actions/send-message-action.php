<?php
session_start();
require '../inclusions/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Non connecté']));
}

if (empty($_POST['sender_id']) || empty($_POST['receiver_id']) || empty($_POST['message'])) {
    die(json_encode(['error' => 'Données manquantes']));
}

$senderId = $_POST['sender_id'];
$receiverId = $_POST['receiver_id'];
$message = htmlspecialchars($_POST['message']);

try {
    $stmt = $pdo->prepare("
        INSERT INTO messages (`sender-msg-id`, `receiver-msg-id`, `msg`, `date-send`)
        VALUES (:sender_id, :receiver_id, :message, NOW())
    ");
    
    $stmt->execute([
        ':sender_id' => $senderId,
        ':receiver_id' => $receiverId,
        ':message' => $message
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Erreur SQL: " . $e->getMessage());
    echo json_encode(['error' => 'Erreur de base de données']);
}