<?php
session_start();
require '../inclusions/database.php';
$post_id = $_GET['post_id'];

$stmt = $pdo->prepare("
    SELECT commentaires.*, users.`last-name`, users.`first-name`, users.`profile-pic` 
    FROM commentaires 
    INNER JOIN users ON commentaires.`unique-id` = users.`unique-id`
    WHERE commentaires.`post-id` = ? 
    ORDER BY commentaires.id DESC
");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='commentaire-section'>"; // Nouveau bloc parent pour ce post

echo "<div class='comments-block'>";
foreach ($comments as $index => $comment) {
    $isHidden = $index >= 2 ? "hidden transition-all duration-300 ease-in-out" : "transition-all duration-300 ease-in-out";

    echo "<div class='comment-item flex items-start gap-3 p-4 border border-gray-300 rounded-xl bg-white shadow-sm mb-3 {$isHidden}'>";
   
    echo "<img src='profile-pic/" . htmlspecialchars($comment['profile-pic']) . "' class='w-10 h-10 rounded-xl object-cover' >";
    
    echo "<div class='flex-1'>";
    echo "<strong class='text-sm font-semibold text-gray-800'>" . htmlspecialchars($comment['last-name'] . ' ' . $comment['first-name']) . "</strong>";
    echo "<p class='text-sm text-gray-700 mt-1'>" . nl2br(htmlspecialchars($comment['comment'])) . "</p>";
    echo "<p class='text-xs text-gray-400 mt-2'>Posté le : " . htmlspecialchars($comment['created_at']) . "</p>";
    echo "</div>";
    
    echo "</div>";
}
echo "</div>";

// Boutons liés au bloc précédent
if (count($comments) > 2) {
    echo "
        <div class='float-left text-center mt-2'>
            <button class='show-more text-blue-600 hover:underline text-sm cursor-pointer outline-0'>Voir plus de commentaires</button>
            <button class='show-less text-blue-600 hover:underline text-sm hidden cursor-pointer outline-0'>Voir moins de commentaires</button>
        </div>
    ";
}

echo "</div>"; 



?>
