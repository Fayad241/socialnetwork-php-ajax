<?php
    session_start();
    require_once '../inclusions/database.php';
    require_once '../inclusions/functions.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Non authentifié']);
        exit;
    }

    $current_user = $_SESSION['user_id'];

    try {
        // Supprimer les stories expirées
        $pdo->exec("DELETE FROM stories WHERE expires_at < NOW()");
        
        // Récupérer les stories actives des amis (et de l'utilisateur)
        $query = "
            SELECT 
                s.id,
                s.user_id,
                s.media,
                s.text,
                s.media_type,
                s.created_at,
                u.`first-name` as user_first_name,
                u.`last-name` as user_last_name,
                u.`profile-pic` as user_pic,
                0 as viewed
            FROM stories s
            JOIN users u ON s.user_id = u.`unique-id`
            WHERE s.expires_at > NOW()
            AND (
                s.user_id = :current_user
                OR s.user_id IN (
                    SELECT CASE 
                        WHEN user_id = :current_user THEN friend_id 
                        ELSE user_id 
                    END
                    FROM friends 
                    WHERE (user_id = :current_user OR friend_id = :current_user)
                )
            )
            ORDER BY s.created_at DESC
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute(['current_user' => $current_user]);
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Grouper par utilisateur
        $grouped = [];
        foreach ($stories as $story) {
            $userId = $story['user_id'];
            
            if (!isset($grouped[$userId])) {
                $grouped[$userId] = [
                    'user_id' => $userId,
                    'user_name' => $story['user_last_name'] . ' ' . $story['user_first_name'],
                    'user_pic' => $story['user_pic'],
                    'stories' => []
                ];
            }
            
            $grouped[$userId]['stories'][] = [
                'id' => $story['id'],
                'media' => $story['media'],
                'text' => $story['text'],
                'media_type' => $story['media_type'],
                'viewed' => (bool)$story['viewed'],
                'time_ago' => timeAgo($story['created_at']),
                'user_name' => $story['user_last_name'] . ' ' . $story['user_first_name'],
                'user_pic' => $story['user_pic']
            ];
        }
        
        // Convertir en array indexé
        $result = array_values($grouped);
        
        echo json_encode([
            'success' => true,
            'stories' => $result
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ]);
    }
?>