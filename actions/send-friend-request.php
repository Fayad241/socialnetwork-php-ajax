<?php
    session_start();
    require '../inclusions/database.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['receiver_id'])) {
        echo json_encode(['success' => false, 'error' => 'Données manquantes']);
        exit;
    }

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $data['receiver_id'];

    // Validation
    if ($sender_id === $receiver_id) {
        echo json_encode(['success' => false, 'error' => 'Vous ne pouvez pas vous ajouter vous-même']);
        exit;
    }

    try {
        // Vérifier si une invitation existe déjà
        $checkStmt = $pdo->prepare("
            SELECT id FROM friend_requests 
            WHERE (sender_id = :sender AND receiver_id = :receiver)
            OR (sender_id = :receiver AND receiver_id = :sender)
        ");
        $checkStmt->execute([
            ':sender' => $sender_id,
            ':receiver' => $receiver_id
        ]);
        
        if ($checkStmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'error' => 'Une invitation existe déjà']);
            exit;
        }
        
        // Vérifier s'ils sont déjà amis
        $friendCheckStmt = $pdo->prepare("
            SELECT id FROM friends 
            WHERE (user_id = :user1 AND friend_id = :user2)
            OR (user_id = :user2 AND friend_id = :user1)
        ");
        $friendCheckStmt->execute([
            ':user1' => $sender_id,
            ':user2' => $receiver_id
        ]);
        
        if ($friendCheckStmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'error' => 'Vous êtes déjà amis']);
            exit;
        }
        
        // Envoyer l'invitation
        $stmt = $pdo->prepare("
            INSERT INTO friend_requests (sender_id, receiver_id, status, created_at) 
            VALUES (:sender, :receiver, 'pending', NOW())
        ");
        
        $stmt->execute([
            ':sender' => $sender_id,
            ':receiver' => $receiver_id
        ]);
        
        // Créer une notification pour le destinataire
        $notifStmt = $pdo->prepare("
            INSERT INTO notifications (user_id, sender_id, type, message, created_at) 
            VALUES (:user_id, :sender_id, 'friend-request', 'vous a envoyé une demande d\'ami', NOW())
        ");
        $notifStmt->execute([
            ':user_id' => $receiver_id,
            ':sender_id' => $sender_id
        ]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Invitation envoyée'
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur base de données'
        ]);
    }
?>