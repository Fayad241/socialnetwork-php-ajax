<?php 
    while($post = $stmt2->fetch(PDO::FETCH_ASSOC)) { 
        $postId = $post['id'];
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

    <div class="post-block flex flex-col justify-center bg-white rounded-2xl shadow-md px-5 py-4 mb-5" data-post-id="<?= htmlspecialchars($postId) ?>">

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

        <img class="h-96 w-full rounded-xl object-cover" src="uploads/posts/<?=$post['img-publication']?>" alt="">
        <?php endif; ?>

        <!-- SECTION INTERACTIONS DYNAMIQUES -->
        <div class="flex items-center justify-between my-4">
            <div class="flex gap-5 items-center justify-between">
                <!-- LIKES -->
                <div class="like-section flex items-center justify-center gap-1 ml-3 cursor-pointer" data-post-id="<?= $postId ?>">
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
                <div class="favorite-section flex items-center gap-1 justify-center cursor-pointer" data-post-id="<?= $postId ?>">
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

        <div class="comments-block hidden items-center gap-4 mb-4 mt-2">
            <div class="flex gap-2 justify-center">
                <img class="w-12 h-12 rounded-xl object-cover" src="assets/images/img_user_publicaton.jpg" alt="">
                <textarea class="commentInput bg-gray-100 rounded-xl w-96 outline-0" placeholder="Commenter ce post" style="resize: none; height: 74px; padding: 6px 12px;"></textarea>
                <input type="hidden" class="postId" value="<?= htmlspecialchars($postId) ?>">
                <input type="hidden" class="uniqueId" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
            </div>
            <button class="commentButton flex justify-center items-center rounded-full bg-blue-500 hover:bg-blue-600 p-2 transition-colors outline-none cursor-pointer">
                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.7639 12H10.0556M3 8.00003H5.5M4 12H5.5M4.5 16H5.5M9.96153 12.4896L9.07002 15.4486C8.73252 16.5688 8.56376 17.1289 8.70734 17.4633C8.83199 17.7537 9.08656 17.9681 9.39391 18.0415C9.74792 18.1261 10.2711 17.8645 11.3175 17.3413L19.1378 13.4311C20.059 12.9705 20.5197 12.7402 20.6675 12.4285C20.7961 12.1573 20.7961 11.8427 20.6675 11.5715C20.5197 11.2598 20.059 11.0295 19.1378 10.5689L11.3068 6.65342C10.2633 6.13168 9.74156 5.87081 9.38789 5.95502C9.0808 6.02815 8.82627 6.24198 8.70128 6.53184C8.55731 6.86569 8.72427 7.42461 9.05819 8.54246L9.96261 11.5701C10.0137 11.7411 10.0392 11.8266 10.0493 11.9137C10.0583 11.991 10.0582 12.069 10.049 12.1463C10.0387 12.2334 10.013 12.3188 9.96153 12.4896Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        <div class="commentsContainer" data-post-id="<?= htmlspecialchars($postId) ?>">
            
        </div>
    </div>

    <?php  } 
      
?>


<script src="assets/js/posts-interactions.js"></script>


