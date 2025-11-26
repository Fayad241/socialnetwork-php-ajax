<?php
    session_start();
    require '../inclusions/database.php';

    header("Content-Type: application/json");

    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification de l'authentification
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "Non authentifié"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $post_id = $data['post_id'];

    if (!$post_id) {
        echo json_encode(["success" => false, "message" => "ID du post manquant"]);
        exit;
    }

    try {
        // Supprimer le post des favoris
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);

        // Récupérer le nouveau total d’enregistrements
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM favorites WHERE user_id = :user_id");
        $countStmt->execute([':user_id' => $user_id]);
        $totalSaved = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        echo json_encode([
            "success" => true,
            "totalSaved" => $totalSaved
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Erreur SQL : " . $e->getMessage()
        ]);
    }
