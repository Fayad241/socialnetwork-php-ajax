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

    $current_user = $_SESSION['user_id'];
    $receiver_id = $data['receiver_id'];

    try {
        // Supprimer l'invitation envoyée
        $stmt = $pdo->prepare("
            DELETE FROM friend_requests 
            WHERE sender_id = :sender_id 
            AND receiver_id = :receiver_id 
            AND status = 'pending'
        ");
        
        $stmt->execute([
            ':sender_id' => $current_user,
            ':receiver_id' => $receiver_id
        ]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Invitation annulée'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Invitation introuvable'
            ]);
        }
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur base de données'
        ]);
    }
?>