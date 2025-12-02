<?php
    session_start();
    require '../inclusions/database.php';
    require '../inclusions/functions.php';

    if (empty($_GET['post_id'])) {
        die("<p class='text-gray-500 text-center'>Erreur: Post ID manquant</p>");
    }

    $post_id = $_GET['post_id'];

    try {
        // Récupérer les commentaires avec les infos utilisateur
        $stmt = $pdo->prepare("
            SELECT 
                c.*,
                u.`first-name`,
                u.`last-name`,
                u.`profile-pic`
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.`unique-id`
            WHERE c.post_id = :post_id
            ORDER BY c.created_at DESC
        ");
        
        $stmt->execute([':post_id' => $post_id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($comments) > 0) {
            echo "<div class='commentaire-section'>";
            echo "<div class='comments-list'>";
            
            foreach ($comments as $index => $comment) {
                $profilePic = $comment['profile-pic'] ?? 'defaultProfile.jpeg';
                $fullName = htmlspecialchars($comment['last-name'] . ' ' . $comment['first-name']);
                $commentText = nl2br(htmlspecialchars($comment['comment_text']));
                $timeAgo = timeAgo($comment['created_at']);
                
                // Masquer les commentaires après les 2 premiers
                $isHidden = $index >= 2 ? "hidden" : "";
                
                echo '
                <div class="comment-item flex items-start gap-3 p-3 border border-gray-200 rounded-xl bg-white mb-3 transition-all duration-300 ' . $isHidden . '">
                    <img class="w-10 h-10 rounded-full object-cover" src="profile-pic/' . $profilePic . '" alt="">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <strong class="text-sm font-semibold text-gray-800">' . $fullName . '</strong>
                            <span class="text-xs text-gray-400">' . $timeAgo . '</span>
                        </div>
                        <p class="text-sm text-gray-700 mt-1">' . $commentText . '</p>
                    </div>
                </div>';
            }
            
            echo "</div>"; 
            
            // Afficher les boutons si plus de 2 commentaires
            if (count($comments) > 2) {
                $remaining = count($comments) - 2;
                echo "
                <div class='text-left mt-2'>
                    <button class='show-more-btn text-blue-600 hover:underline text-sm cursor-pointer outline-0 font-medium'>
                        Voir " . $remaining . " commentaire" . ($remaining > 1 ? "s" : "") . " de plus
                    </button>
                    <button class='show-less-btn text-blue-600 hover:underline text-sm hidden cursor-pointer outline-0 font-medium'>
                        Voir moins de commentaires
                    </button>
                </div>";
            }
            
            echo "</div>"; 
            
        } else {
            echo '<p class="text-gray-500 text-center text-sm py-4">Aucun commentaire pour le moment</p>';
        }
        
    } catch (PDOException $e) {
        echo '<p class="text-red-500 text-center">Erreur de chargement des commentaires</p>';
    }
?>