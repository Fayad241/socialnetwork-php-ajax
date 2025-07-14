<?php
session_start();
require '../inclusions/database.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
        exit;
    }

    // if (empty($_POST['content'])) {
    //     http_response_code(400);
    //     echo json_encode(['success' => false, 'message' => 'Le contenu de la publication est requis']);
    //     exit;
    // }

    $content = trim($_POST['content']);
    $imageName = null;

    // Gestion de l'image si présente
    if (isset($_FILES['img-publication']) && $_FILES['img-publication']['error'] === 0) {
        $imgTmp = $_FILES['img-publication']['tmp_name'];
        $imgName = $_FILES['img-publication']['name'];
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($imgExt, $allowed)) {
            echo json_encode(['success' => false, 'message' => 'Format d’image non autorisé']);
            exit;
        }

        $imageName = time() . '_' . uniqid() . '.' . $imgExt;
        move_uploaded_file($imgTmp, '../uploads/posts/' . $imageName);
    }


    $userId = $_SESSION['user-id'];
    $datePost = date('Y-m-d H:i:s');;

    $sql = "INSERT INTO `posts` (`content`, `img-publication`, `date-publication`, `unique-id`) VALUES (:content, :image, :date, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':image', $imageName);
    $stmt->bindParam(':date', $datePost);
    $stmt->bindParam(':user_id', $userId);

    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Publication enregistrée avec succès']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()]);
}
