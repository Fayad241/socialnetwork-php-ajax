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

    try {
        // Vérifier si l'utilisateur a déjà liké
        $checkStmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = :user_id AND post_id = :post_id");
        $checkStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);
        
        if ($checkStmt->rowCount() > 0) {
            // Retirer le like
            $deleteStmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id");
            $deleteStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);
            $liked = false;
        } else {
            // Ajouter le like
            $insertStmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
            $insertStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);
            $liked = true;
        }
        
        // Compter le nombre total de likes
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM likes WHERE post_id = :post_id");
        $countStmt->execute([':post_id' => $post_id]);
        $count = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo json_encode([
            'success' => true,
            'liked' => $liked,
            'count' => $count
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur base de données']);
    }
?>