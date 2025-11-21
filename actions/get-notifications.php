<?php
    session_start();
    require '../inclusions/database.php';
    require '../inclusions/functions.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Non authentifié']);
        exit;
    }

    $current_user = $_SESSION['user_id'];

    try {
        // Récupérer toutes les notifications de l'utilisateur
        $query = "
            SELECT 
                n.id,
                n.type,
                n.sender_id,
                n.message,
                n.post_id,
                n.is_read,
                n.created_at,
                u.`first-name` as sender_first_name,
                u.`last-name` as sender_last_name,
                u.`profile-pic` as sender_pic
            FROM notifications n
            JOIN users u ON n.sender_id = u.`unique-id`
            WHERE n.user_id = :user_id
            ORDER BY n.created_at DESC
            LIMIT 50
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $current_user]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Formater les notifications
        $formatted_notifications = [];
        foreach ($notifications as $notif) {
            $formatted_notifications[] = [
                'id' => $notif['id'],
                'type' => $notif['type'],
                'sender_id' => $notif['sender_id'],
                'sender_name' => $notif['sender_last_name'] . ' ' . $notif['sender_first_name'],
                'sender_pic' => $notif['sender_pic'],
                'message' => $notif['message'],
                'post_id' => $notif['post_id'],
                'is_read' => (bool)$notif['is_read'],
                'time_ago' => timeAgo($notif['created_at'])
            ];
        }
        
        // Compter les notifications non lues
        $unread_query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND is_read = 0";
        $unread_stmt = $pdo->prepare($unread_query);
        $unread_stmt->execute(['user_id' => $current_user]);
        $unread_count = $unread_stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        echo json_encode([
            'success' => true,
            'notifications' => $formatted_notifications,
            'unread_count' => (int)$unread_count
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ]);
    }