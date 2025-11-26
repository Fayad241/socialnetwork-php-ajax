<?php
    session_start();
    require '../inclusions/database.php';
    require '../inclusions/functions.php';

    header("Content-Type: application/json");

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "Non authentifié"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    try {

        $sql = "
            SELECT posts.id, posts.content, posts.`img-publication`, posts.`created_at`, users.`last-name`, users.`first-name`, users.`profile-pic`
            FROM favorites
            INNER JOIN posts ON posts.id = favorites.post_id
            INNER JOIN users ON users.`unique-id` = posts.user_id
            WHERE favorites.user_id = ?
            ORDER BY favorites.created_at DESC
        ";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as $i => $post) {
            $posts[$i]['timeAgo'] = timeAgo($post['created_at']);
        }

        // le nombre total de favoris
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM favorites WHERE user_id = :user_id");
        $countStmt->execute([':user_id' => $user_id]);
        $totalSaved = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    
        echo json_encode([
            "success" => true,
            "posts" => $posts,
            "totalSaved" => $totalSaved
        ]);
    }  catch (PDOException $e) {
        
        echo json_encode([
            "success" => false,
            "message" => "Erreur SQL : " . $e->getMessage()
        ]);
    }
