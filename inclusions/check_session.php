<?php
    session_start();
    require 'database.php';
    require 'functions.php';

    if(isset($_SESSION['user_id'])) {
        // Vérifier si la dernière mise à jour date de plus de 2 minutes
        if(!isset($_SESSION['last_activity_update']) || 
        (time() - $_SESSION['last_activity_update']) > 120) {
            
            $stmt = $pdo->prepare("UPDATE users SET `last-activity` = NOW() WHERE `unique-id` = :user_id");
            $stmt->execute([':user_id' => $_SESSION['user_id']]);
            
            $_SESSION['last_activity_update'] = time();
        }
    }
?>