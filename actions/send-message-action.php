<?php
    session_start();
    require '../inclusions/database.php';

    header('Content-Type: application/json');

    // Vérification de la connexion
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }

    // Récupération des données JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['receiver_id']) || empty($data['message'])) {
        echo json_encode(['success' => false, 'error' => 'Données manquantes']);
        exit;
    }

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $data['receiver_id'];
    $message = trim($data['message']);

    // Validation
    if (strlen($message) > 1000) {
        echo json_encode(['success' => false, 'error' => 'Message trop long']);
        exit;
    }

    try {
        // Insertion du message
        $stmt = $pdo->prepare("
            INSERT INTO messages (`sender-msg-id`, `receiver-msg-id`, `msg`, `date-send`) 
            VALUES (:sender, :receiver, :message, NOW())
        ");
        
        $stmt->execute([
            ':sender' => $sender_id,
            ':receiver' => $receiver_id,
            ':message' => $message
        ]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Message envoyé'
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur base de données'
        ]);
    }
?>