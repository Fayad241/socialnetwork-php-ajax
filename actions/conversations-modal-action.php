<?php 
    session_start();
    require '../inclusions/database.php';
    // require __DIR__ . '/../inclusions/functions.php';

    $current_user = $_SESSION['user_id'];

    if (!isset($_SESSION['user_id'])) {
        die(json_encode(['error' => 'Non connecté'])); 
    }

    $sql = $pdo->prepare("SELECT * FROM users WHERE NOT `unique-id` = :user_id");
    $sql->execute([':user_id' => $_SESSION['user_id']]);

    $output = '';

    if($sql->rowCount() == 1) {
        $output .= "Aucun utilisateur disponible dans le chat";
    } else if($sql->rowCount() > 0) {
        require __DIR__ . '/../inclusions/data.php';
    }
    echo $output;


?>