<?php
    session_start();
    require '../inclusions/database.php';

    header('Content-Type: application/json');

    if (empty($_GET['post_id'])) {
        echo json_encode(['success' => false, 'error' => 'Post ID manquant']);
        exit;
    }

    $post_id = $_GET['post_id'];
    $user_id = $_SESSION['user_id'] ?? null;

    try {
        // Compter les likes
        $likesStmt = $pdo->prepare("SELECT COUNT(*) as total FROM likes WHERE post_id = :post_id");
        $likesStmt->execute([':post_id' => $post_id]);
        $likesCount = $likesStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Vérifier si l'utilisateur a liké
        $userLiked = false;
        if ($user_id) {
            $userLikedStmt = $pdo->prepare("SELECT id FROM likes WHERE post_id = :post_id AND user_id = :user_id");
            $userLikedStmt->execute([':post_id' => $post_id, ':user_id' => $user_id]);
            $userLiked = $userLikedStmt->rowCount() > 0;
        }
        
        // Compter les commentaires
        $commentsStmt = $pdo->prepare("SELECT COUNT(*) as total FROM comments WHERE post_id = :post_id");
        $commentsStmt->execute([':post_id' => $post_id]);
        $commentsCount = $commentsStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Compter les favoris
        $favStmt = $pdo->prepare("SELECT COUNT(*) as total FROM favorites WHERE post_id = :post_id");
        $favStmt->execute([':post_id' => $post_id]);
        $favCount = $favStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Vérifier si l'utilisateur a mis en favori
        $userFavorited = false;
        if ($user_id) {
            $userFavStmt = $pdo->prepare("SELECT id FROM favorites WHERE post_id = :post_id AND user_id = :user_id");
            $userFavStmt->execute([':post_id' => $post_id, ':user_id' => $user_id]);
            $userFavorited = $userFavStmt->rowCount() > 0;
        }
        
        echo json_encode([
            'success' => true,
            'likes' => $likesCount,
            'user_liked' => $userLiked,
            'comments' => $commentsCount,
            'favorites' => $favCount,
            'user_favorited' => $userFavorited
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur base de données']);
    }
?>