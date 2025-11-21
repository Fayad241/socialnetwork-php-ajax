<?php
    session_start();
    require '../inclusions/database.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['post_id'])) {
        echo json_encode(['success' => false, 'error' => 'Post ID manquant']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $post_id = $data['post_id'];
    $post_author_id = $data['post_author_id'];

    try {
        // Vérifier si l'utilisateur a déjà mis en favori
        $checkStmt = $pdo->prepare("SELECT id FROM favorites WHERE user_id = :user_id AND post_id = :post_id");
        $checkStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);
        
        if ($checkStmt->rowCount() > 0) {
            // Retirer des favoris
            $deleteStmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = :user_id AND post_id = :post_id");
            $deleteStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);
            $favorited = false;

            // Suppression notification
            $deleteNotif = $pdo->prepare("
                DELETE FROM notifications 
                WHERE user_id = :receiver AND sender_id = :sender AND type = 'favorite' AND post_id = :post_id
            ");
            $deleteNotif->execute([
                ':receiver' => $post_author_id,
                ':sender' => $user_id,
                ':post_id' => $post_id
            ]);
        } else {
            // Ajouter aux favoris
            $insertStmt = $pdo->prepare("INSERT INTO favorites (user_id, post_id) VALUES (:user_id, :post_id)");
            $insertStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);
            $favorited = true;

            if ($user_id != $post_author_id) {
                // Insertion notification
                $notifStmt = $pdo->prepare("
                    INSERT INTO notifications (user_id, sender_id, type, message, post_id, created_at) 
                    VALUES (:receiver, :sender, 'favorite', 'a mis votre publication en favoris', :post_id, NOW())
                ");
                $notifStmt->execute([
                    ':receiver' => $post_author_id,
                    ':sender' => $user_id,
                    ':post_id' => $post_id
                ]);
            }
        }
        
        // Compter le nombre total de favoris
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM favorites WHERE post_id = :post_id");
        $countStmt->execute([':post_id' => $post_id]);
        $count = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo json_encode([
            'success' => true,
            'favorited' => $favorited,
            'count' => $count
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur base de données']);
    }
?>