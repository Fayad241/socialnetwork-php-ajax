<?php 
    session_start();
    require '../inclusions/database.php';
    
    $current_user = $_SESSION['user_id'];
    $searchInput = $_POST['searchInput'] ?? ''; 
    $output = "";

    // Rechercher dans la combinaison prénom + nom
    $sql = $pdo->prepare("
        SELECT * FROM users 
        WHERE `unique-id` != :user_id 
        AND (
            `last-name` LIKE :search 
            OR `first-name` LIKE :search
            OR CONCAT(`first-name`, ' ', `last-name`) LIKE :search
            OR CONCAT(`last-name`, ' ', `first-name`) LIKE :search
        )
    ");

    $sql->execute([
        ':user_id' => $current_user,
        ':search' => "%$searchInput%"
    ]);

    if ($sql->rowCount() > 0) {
        require '../inclusions/data.php';
    } else {
        $output .= "<p class='text-gray-500 text-center'>Aucun utilisateur trouvé</p>";
    }

    echo $output;
?>