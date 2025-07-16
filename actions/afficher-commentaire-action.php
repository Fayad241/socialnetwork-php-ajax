<?php
session_start();
require '../inclusions/database.php';
$post_id = $_GET['post_id'];

$stmt = $pdo->prepare("SELECT * FROM commentaires WHERE `post-id` = ? ORDER BY id DESC");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($comments as $comment) {
    echo "<div style='border:1px solid #ccc; margin:5px; padding:5px'>";
    echo "<strong>Utilisateur :</strong> " . htmlspecialchars($comment['unique-id']) . "<br>";
    echo "<p>" . nl2br(htmlspecialchars($comment['comment'])) . "</p>";
    echo "</div>";
}
?>
