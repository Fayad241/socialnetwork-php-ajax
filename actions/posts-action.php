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

        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $imageName = null;

        // Gestion de l'image si présente
        if (!empty($_FILES['img-publication']) && $_FILES['img-publication']['error'] === 0) {

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

        // Vérification session
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $userId = $_SESSION['user_id'];
        $datePost = date('Y-m-d H:i:s');

        $sql = "INSERT INTO posts (content, `img-publication`, `date-publication`, `user_id`) 
                VALUES (:content, :image, :date, :user_id)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':content' => $content,
            ':image'   => $imageName ?? null,
            ':date'    => $datePost,
            ':user_id' => $userId
        ]);

        echo json_encode(['success' => true, 'message' => 'Publication enregistrée avec succès']);

    } catch (PDOException $e) {
        file_put_contents("log.txt", $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
