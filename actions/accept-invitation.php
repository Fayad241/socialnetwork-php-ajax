<?php
    session_start();
    require '../inclusions/database.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['sender_id'])) {
        echo json_encode(['success' => false, 'error' => 'Données manquantes']);
        exit;
    }

    $current_user = $_SESSION['user_id'];
    $sender_id = $data['sender_id'];

    try {
        $pdo->beginTransaction();
        
        // Vérifier que l'invitation existe
        $checkStmt = $pdo->prepare("
            SELECT id FROM friend_requests 
            WHERE sender_id = :sender_id 
            AND receiver_id = :receiver_id 
            AND status = 'pending'
        ");
        $checkStmt->execute([
            ':sender_id' => $sender_id,
            ':receiver_id' => $current_user
        ]);
        
        if ($checkStmt->rowCount() === 0) {
            throw new Exception('Invitation introuvable');
        }
        
        // Créer la relation d'amitié (bidirectionnelle)
        $friendStmt = $pdo->prepare("
            INSERT INTO friends (user_id, friend_id, created_at) 
            VALUES 
            (:user1, :user2, NOW()),
            (:user2, :user1, NOW())
        ");
        $friendStmt->execute([
            ':user1' => $current_user,
            ':user2' => $sender_id
        ]);
        
        // Supprimer l'invitation
        $deleteStmt = $pdo->prepare("
            DELETE FROM friend_requests 
            WHERE sender_id = :sender_id 
            AND receiver_id = :receiver_id
        ");
        $deleteStmt->execute([
            ':sender_id' => $sender_id,
            ':receiver_id' => $current_user
        ]);
        
        // Créer une notification pour l'expéditeur
        $notifStmt = $pdo->prepare("
            INSERT INTO notifications (user_id, sender_id, type, message, created_at) 
            VALUES (:user_id, :sender_id, 'friend-accepted', 'a accepté votre demande d\'ami', NOW())
        ");
        $notifStmt->execute([
            ':user_id' => $sender_id,
            ':sender_id' => $current_user
        ]);
        
        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Invitation acceptée'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
?>