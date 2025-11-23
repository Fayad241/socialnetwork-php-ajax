<?php
    session_start();
    require_once '../inclusions/database.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Non authentifié']);
        exit;
    }

    $current_user = $_SESSION['user_id'];

    try {

        $text = $_POST['text'] ?? '';
        $new_filename = null;
        $duration = (int)($_POST['duration'] ?? 24);


        if (empty($text) && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Veuillez ajouter du texte, une image ou une vidéo']);
            exit;
        }
        
        // Valider la durée
        if (!in_array($duration, [6, 12, 24])) {
            $duration = 24;
        }  

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $fileTmp = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'webm'];
            if (!in_array($fileExt, $allowed)) {
                echo json_encode(['success' => false, 'message' => 'Format d’image non autorisé']);
                exit;
            }

            $new_filename = time() . '_' . uniqid() . '.' . $fileExt;
            move_uploaded_file($fileTmp, __DIR__ . '/../uploads/stories/' . $new_filename);
        }
        
        // Calculer la date d'expiration
        $expires_at = date('Y-m-d H:i:s', strtotime("+$duration hours"));
        
        // Insérer dans la base de données
        $stmt = $pdo->prepare("
            INSERT INTO stories (user_id, image, text, duration_hours, expires_at, created_at)
            VALUES (:user_id, :image, :text, :duration, :expires_at, NOW())
        ");
        
        $stmt->execute([
            'user_id' => $current_user,
            'image' => $new_filename ?? null,
            'text' => $text,
            'duration' => $duration,
            'expires_at' => $expires_at
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Story publiée']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
?>