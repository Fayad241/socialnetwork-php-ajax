<?php
session_start();
require '../inclusions/database.php';

// Réception des données JSON
$data = json_decode(file_get_contents("php://input"), true);

$comment = trim($data['comment']);
$post_id = $data['post_id'];
$unique_id = $data['unique_id'];

// Vérifie que le commentaire n'est pas vide
if (!empty($comment)) {
    $stmt = $pdo->prepare("INSERT INTO commentaires (`comment`, `post-id`, `unique-id`, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$comment, $post_id, $unique_id]);
    echo json_encode(['status' => 'success', 'message' => 'Commentaire ajouté.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Commentaire vide.']);
}
?>
