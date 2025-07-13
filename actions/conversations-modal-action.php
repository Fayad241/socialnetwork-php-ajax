<?php 
    session_start();
    require '../inclusions/database.php';

    if (!isset($_SESSION['user-id'])) {
        die(json_encode(['error' => 'Non connecté'])); 
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE NOT `unique-id` = :user_id");
    $stmt->execute([':user_id' => $_SESSION['user-id']]);

    $output = '';

    if($stmt->rowCount() == 1) {
        $output .= "Aucun utilisateur disponible dans le chat";
    } else if($stmt->rowCount() > 0) {
        require '../inclusions/data.php';
    }
    echo $output;


?>