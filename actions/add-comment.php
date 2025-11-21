<?php
    session_start();
    require '../inclusions/database.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['post_id']) || empty($data['comment'])) {
        echo json_encode(['success' => false, 'error' => 'Données manquantes']);
        exit;
    }

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $data['receiver_id'];
    $post_id = $data['post_id'];
    $comment = trim($data['comment']);

    // Validation
    if (strlen($comment) > 1000) {
        echo json_encode(['success' => false, 'error' => 'Commentaire trop long']);
        exit;
    }

    try {
        // Insérer le commentaire
        $stmt = $pdo->prepare("
            INSERT INTO comments (post_id, user_id, comment_text, created_at) 
            VALUES (:post_id, :user_id, :comment, NOW())
        ");
        
        $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $sender_id,
            ':comment' => $comment
        ]);

        if ($sender_id != $receiver_id) {
            // Créer une notification pour le destinataire
            $notifStmt = $pdo->prepare("
                INSERT INTO notifications (user_id, sender_id, type, message, post_id, created_at) 
                VALUES (:user_id, :sender_id, 'comment', 'a commenté votre publication', :post_id, NOW())
            ");
            $notifStmt->execute([
                ':user_id' => $receiver_id,
                ':sender_id' => $sender_id,
                ':post_id' => $post_id
            ]);
        }
        
        // Compter le nombre total de commentaires
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM comments WHERE post_id = :post_id");
        $countStmt->execute([':post_id' => $post_id]);
        $totalComments = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Commentaire ajouté',
            'total_comments' => $totalComments
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur base de données']);
    }
?>