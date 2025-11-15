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

    $user_id = $_SESSION['user_id'];
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
            ':user_id' => $user_id,
            ':comment' => $comment
        ]);
        
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