<?php 

    // Requete pour affichage des posts
    $stmt2 = $pdo->prepare("SELECT 
        posts.id AS post_id,
        posts.id,
        posts.content,
        posts.`img-publication`,
        posts.`date-publication`,
        posts.`created_at`,
        posts.`user_id`,
        users.`first-name`,
        users.`last-name`,
        users.`profile-pic`,
        users.email
        FROM posts
        INNER JOIN users ON posts.`user_id` = users.`unique-id`
        ORDER BY posts.`date-publication` DESC;
    ");
    $stmt2->execute();

    while($post = $stmt2->fetch(PDO::FETCH_ASSOC)) { 
        $postId = $post['id'];
        $authorId = $post['user_id'];
        $currentUser = $_SESSION['user_id'];
        
        // Compter les likes
        $likesStmt = $pdo->prepare("SELECT COUNT(*) as total FROM likes WHERE post_id = :post_id");
        $likesStmt->execute([':post_id' => $postId]);
        $likesCount = $likesStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Vérifier si l'utilisateur a liké
        $userLikedStmt = $pdo->prepare("SELECT id FROM likes WHERE post_id = :post_id AND user_id = :user_id");
        $userLikedStmt->execute([':post_id' => $postId, ':user_id' => $currentUser]);
        $userHasLiked = $userLikedStmt->rowCount() > 0;
        
        // Compter les commentaires
        $commentsStmt = $pdo->prepare("SELECT COUNT(*) as total FROM comments WHERE post_id = :post_id");
        $commentsStmt->execute([':post_id' => $postId]);
        $commentsCount = $commentsStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Compter les favoris
        $favStmt = $pdo->prepare("SELECT COUNT(*) as total FROM favorites WHERE post_id = :post_id");
        $favStmt->execute([':post_id' => $postId]);
        $favCount = $favStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Vérifier si l'utilisateur a mis en favori
        $userFavStmt = $pdo->prepare("SELECT id FROM favorites WHERE post_id = :post_id AND user_id = :user_id");
        $userFavStmt->execute([':post_id' => $postId, ':user_id' => $currentUser]);
        $userHasFavorited = $userFavStmt->rowCount() > 0;
    ?>

    <div class="post-block flex flex-col justify-center bg-white rounded-2xl shadow-md md:px-5 px-3 py-4 mb-5" data-post-id="<?= htmlspecialchars($postId) ?>">

        <div class="flex items-center justify-between">
            <div class="flex gap-3 items-center justify-center">
                <img class="w-10 h-10 rounded object-cover" src="profile-pic/<?=$post['profile-pic']?>" alt="">
                <div>
                    <p class="font-bold"><?= htmlspecialchars($post['last-name'] . ' ' . $post['first-name']); ?></p>
                    <p class="text-gray-400"><?= timeAgo($post['created_at']) ?></p>
                </div>
            </div>
            <div class="flex items-center justify-center rounded border px-4 text-gray-400 w-5 h-5" style="padding-bottom: 21px;">
                <p class="flex items-center justify-center w-2 h-3 text-3xl">...</p>      
            </div>
        </div>
        <div class="my-4">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>


        <?php if(!empty($post['img-publication'])): ?>

        <img class="h-[90vh] w-full rounded-xl object-cover" src="uploads/posts/<?=$post['img-publication']?>" alt="">
        <?php endif; ?>

        <!-- SECTION INTERACTIONS DYNAMIQUES -->
        <div class="flex items-center justify-between my-4">
            <div class="flex gap-5 items-center justify-between">
                <!-- LIKES -->
                <div class="like-section flex items-center justify-center gap-1 ml-3 cursor-pointer" data-post-id="<?= $postId ?>" data-author-id="<?= $authorId ?>">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="like-icon w-6 h-6 <?= $userHasLiked ? 'text-red-500' : 'text-gray-700 hover:text-red-500' ?> transition-colors"
                        fill="<?= $userHasLiked ? 'currentColor' : 'none' ?>"
                        stroke="currentColor"
                        stroke-width="<?= $userHasLiked ? '0' : '1.5' ?>"
                        viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <p class="like-count text-gray-900"><?= $likesCount ?></p>
                </div>
                
                <!-- COMMENTAIRES -->
                <div class="comment-toggle gap-1 flex items-center justify-center cursor-pointer" data-post-id="<?= $postId ?>">
                    <svg class="w-6 h-6 text-gray-700 hover:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12c0 4.97-4.03 9-9 9a8.96 8.96 0 01-4.479-1.175L3 21l1.175-4.479A8.96 8.96 0 013 12c0-4.97 4.03-9 9-9s9 4.03 9 9z" />
                    </svg>
                    <p class="comment-count text-gray-900"><?= $commentsCount ?></p>
                </div>

                <!-- FAVORIS -->
                <div class="favorite-section flex items-center gap-1 justify-center cursor-pointer" data-post-id="<?= $postId ?>" data-author-id="<?= $authorId ?>">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="favorite-icon w-6 h-6 <?= $userHasFavorited ? 'text-yellow-500' : 'text-gray-700 hover:text-yellow-500' ?> transition-colors" 
                        fill="<?= $userHasFavorited ? 'currentColor' : 'none' ?>" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor" 
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-4-7 4V5z" />
                    </svg>
                    <?php if($favCount > 0): ?>
                    <span class="favorite-count"><?= $favCount ?></span>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <div class="comments-block hidden items-center gap-2 md:gap-4 mb-4 mt-2">
            <div class="flex gap-2 justify-center w-full sm:w-auto">
                <img class="w-11 h-11 rounded-xl object-cover ring-2 ring-gray-200" src="assets/images/img_user_publicaton.jpg" alt="">

                <textarea class="commentInput bg-gray-100 rounded-xl w-full sm:w-96 ring-1 ring-gray-200 outline-0"
                    placeholder="Commenter ce post"
                    style="resize: none; height: 74px; padding: 6px 12px;"></textarea>

                <input type="hidden" class="postId" value="<?= htmlspecialchars($postId) ?>">
                <input type="hidden" class="receiverId" value="<?= htmlspecialchars($authorId) ?>">
            </div>

            <!-- Bouton envoyer -->
            <button class="commentButton flex justify-center items-center rounded-full bg-blue-500 hover:bg-blue-600 p-2 transition-colors outline-none cursor-pointer">
                <svg class="w-6 h-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.94 2.94a1.5 1.5 0 0 1 1.58-.35l12 4.5a1.5 1.5 0 0 1 0 2.82l-12 4.5A1.5 1.5 0 0 1 2 13.06V11l8-1-8-1V2.94z"/>
                </svg>
            </button>
        </div>

        <div class="commentsContainer" data-post-id="<?= htmlspecialchars($postId) ?>">
            
        </div>
    </div>

    <?php  } 
      
?>


<script src="assets/js/posts-interactions.js"></script>


