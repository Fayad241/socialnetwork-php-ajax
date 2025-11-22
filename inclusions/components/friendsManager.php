


<?php 
    // REQUÊTE SUGGESTIONS D'AMIS
    $stmt1 = $pdo->prepare("
        SELECT u.* 
        FROM users u
        WHERE u.`unique-id` != :current_user
        
        -- Exclure les utilisateurs qui sont déjà amis
        AND u.`unique-id` NOT IN (
            SELECT `friend_id` 
            FROM `friends` 
            WHERE `user_id` = :current_user
        )
        
        -- Exclure les utilisateurs à qui on a déjà envoyé une invitation
        AND u.`unique-id` NOT IN (
            SELECT `receiver_id` 
            FROM `friend_requests` 
            WHERE `sender_id` = :current_user 
            AND `status` = 'pending'
        )
        
        -- Exclure les utilisateurs qui nous ont déjà envoyé une invitation
        AND u.`unique-id` NOT IN (
            SELECT `sender_id` 
            FROM `friend_requests` 
            WHERE `receiver_id` = :current_user 
            AND `status` = 'pending'
        )
        
        ORDER BY RAND()
        LIMIT 20
    ");
    $stmt1->execute([':current_user' => $current_user]);
    $usersList = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Diviser en deux premières suggestions + le reste
    $firstTwo = array_slice($usersList, 0, 2);
    $others = array_slice($usersList, 2);


    // REQUÊTE INVITATIONS REÇUES
    $stmt3 = $pdo->prepare("
        SELECT u.*, ia.`created_at` as created_at
        FROM users u
        JOIN `friend_requests` ia ON u.`unique-id` = ia.`sender_id`
        WHERE ia.`receiver_id` = :user_id 
        AND ia.`status` = 'pending'
        ORDER BY ia.`created_at` DESC
    ");
    $stmt3->execute([':user_id' => $current_user]);
    

    // REQUÊTE INVITATIONS ENVOYÉES
    $stmt4 = $pdo->prepare("
        SELECT u.*, ia.`created_at` as created_at
        FROM users u
        JOIN `friend_requests` ia ON u.`unique-id` = ia.`receiver_id`
        WHERE ia.`sender_id` = :user_id 
        AND ia.`status` = 'pending'
        ORDER BY ia.`created_at` DESC
    ");
    $stmt4->execute([':user_id' => $current_user]);
    $invitationsEnvoyees = $stmt4->fetchAll(PDO::FETCH_ASSOC);
?>


<?php 
// INVITATIONS RECUES
?>

<div class="flex flex-col justify-center">

    <div class="flex items-center justify-between mb-2">
        <div class="text-gray-800 font-semibold tracking-wide text-sm">INVITATIONS REÇUES</div>
        <div id="received-invitations-count" class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">
            <?= $stmt3->rowCount() ?>
        </div>
    </div>

    <div id="received-invitations-list">

        <?php if ($stmt3->rowCount() > 0): ?>
            <?php while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)): ?>

                <div class="invitation-received-item flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md p-4 mb-4 text-sm" 
                    data-sender-id="<?= $row['unique-id'] ?>">

                    <div class="flex gap-3 justify-center w-full">
                        <div class="flex gap-3 items-center justify-center">
                            <img class="w-10 h-10 object-cover rounded" src="profile-pic/<?= htmlspecialchars($row['profile-pic']) ?>" alt="">
                            <div class="">
                                <strong><?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']); ?></strong> 
                                veut faire partie de vos amis
                            </div>
                        </div>
                        <div class="text-gray-600 text-sm font-bold"><?= timeAgo($row['created_at']) ?></div>
                    </div>

                    <div class="flex gap-4 items-center justify-center">
                        <button 
                            class="btn-accept-invite w-full rounded-xl px-5 py-2 text-sm whitespace-nowrap cursor-pointer outline-none text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0"
                            style="width: 105px;" 
                            data-sender-id="<?= $row['unique-id'] ?>"
                            data-user-name="<?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']) ?>">
                            Accepter
                        </button>

                        <button 
                            class="btn-reject-invite flex items-center justify-center rounded-xl px-5 py-2 text-sm cursor-pointer outline-none font-medium bg-gray-100 text-gray-700 border border-gray-300 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 active:translate-y-0"
                            style="width: 105px;"
                            data-sender-id="<?= $row['unique-id'] ?>"
                            data-user-name="<?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']) ?>">
                            Refuser
                        </button>
                    </div>

                </div>

            <?php endwhile; ?>
        
        <?php else: ?>
            <div class="text-gray-600 italic text-sm text-center py-2">Aucune invitation reçue.</div>
        <?php endif; ?>

    </div>
</div>



<?php 
// INVITATIONS ENVOYEES
?>

<div class="flex flex-col justify-center">

    <div class="flex items-center justify-between mb-2">
        <div class="text-gray-800 font-semibold tracking-wide text-sm">INVITATIONS ENVOYÉES</div>
        <div id="sent-invitations-count" class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">
            <?= count($invitationsEnvoyees) ?>
        </div>
    </div>

    <div id="sent-invitations-list">

        <?php if (empty($invitationsEnvoyees)): ?>

            <div class="text-gray-600 italic text-sm text-center py-2">
                Aucune invitation envoyée pour l'instant.
            </div>

        <?php else: ?>

            <!-- Deux premières invitations -->
            <div id="invites-limited">
                <?php foreach (array_slice($invitationsEnvoyees, 0, 2) as $row): ?>

                    <div class="invitation-sent-item flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md p-4 mb-4 text-sm"
                        data-receiver-id="<?= $row['unique-id'] ?>">

                        <div class="flex gap-3 justify-center w-full">
                            <div class="flex gap-3 items-center justify-center">
                                <img class="w-10 h-10 object-cover rounded" src="profile-pic/<?= $row['profile-pic'] ?>" alt="">
                                <div class="break-words w-44">
                                    Invitation envoyée à 
                                    <strong><?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']); ?></strong>
                                </div>
                            </div>
                            <div class="text-gray-600 text-sm font-bold"><?= timeAgo($row['created_at']) ?></div>
                        </div>

                        <button 
                            class="btn-cancel-invite flex items-center justify-center rounded-xl px-5 py-2 mt-1 text-sm w-full cursor-pointer outline-none font-medium text-white bg-gradient-to-r from-rose-500 to-red-400 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0" 
                            data-receiver-id="<?= $row['unique-id'] ?>" 
                            data-user-name="<?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']) ?>"
                            data-profile-pic="<?= $row['profile-pic'] ?>">
                            Annuler
                        </button>

                    </div>

                <?php endforeach; ?>
            </div>

            <!-- Le reste masqué -->
            <div id="invites-full" class="hidden">
                <?php foreach (array_slice($invitationsEnvoyees, 2) as $row): ?>

                    <div class="invitation-sent-item flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md p-4 mb-4 text-sm"
                        data-receiver-id="<?= $row['unique-id'] ?>">

                        <div class="flex gap-3 justify-center w-full">
                            <div class="flex gap-3 items-center justify-center">
                                <img class="w-10 h-10 object-cover rounded" src="profile-pic/<?= $row['profile-pic'] ?>" alt="">
                                <div class="break-words w-44">
                                    Invitation envoyée à 
                                    <strong><?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']); ?></strong>
                                </div>
                            </div>
                            <div class="text-gray-600 text-sm font-bold"><?= timeAgo($row['created_at']) ?></div>
                        </div>

                        <button 
                            class="btn-cancel-invite flex items-center justify-center rounded-xl px-5 py-2 mt-1 text-sm w-full cursor-pointer outline-none font-medium text-white bg-gradient-to-r from-rose-500 to-red-400 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0" 
                            data-receiver-id="<?= $row['unique-id'] ?>" 
                            data-user-name="<?= htmlspecialchars($row['last-name'] . ' ' . $row['first-name']) ?>"
                            data-profile-pic="<?= $row['profile-pic'] ?>">
                            Annuler
                        </button>

                    </div>

                <?php endforeach; ?>
            </div>

            <?php if (count($invitationsEnvoyees) > 2): ?>
                <button id="toggle-invites" 
                    class="px-5 py-2 mb-2 rounded-xl text-sm text-blue-600 bg-gray-100 shadow-[4px_4px_8px_#c5c5c5,_-4px_-4px_8px_#ffffff] hover:shadow-inner border border-blue-500 transition-all cursor-pointer outline-none">
                    <span class="toggle-text-sent-invites">Voir plus</span>
                </button>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>




<?php 
// SUGGESTIONS D'AMIS
?>

<div class="flex flex-col justify-center">

    <div class="text-gray-800 font-semibold tracking-wide text-sm mb-2">SUGGESTIONS D'AMIS</div>

    <?php if (empty($usersList)): ?>

        <div class="text-gray-600 italic text-sm text-center py-2">
            Aucune suggestion disponible.
        </div>

    <?php else: ?>

        <div id="suggestions-list">

            <!-- Deux premières suggestions -->
            <div id="suggestion-limited">

                <?php foreach ($firstTwo as $users): ?>

                    <div class="suggestion-item bg-white rounded-2xl shadow-md p-4 mb-4 text-sm"
                        data-user-id="<?= $users['unique-id'] ?>">

                        <div class="flex items-center gap-3">
                            <img class="w-13 h-13 object-cover rounded" src="profile-pic/<?= $users['profile-pic'] ?>" alt="">

                            <div class="flex gap-3 flex-col w-full">
                                <strong><?= htmlspecialchars($users['last-name'] . ' ' . $users['first-name']); ?></strong>

                                <button 
                                    class="btn-add-friend w-full rounded-xl px-5 py-2 text-sm whitespace-nowrap cursor-pointer outline-none font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0"
                                    data-user-id="<?= $users['unique-id'] ?>" 
                                    data-user-name="<?= htmlspecialchars($users['last-name'] . ' ' . $users['first-name']) ?>"
                                    data-profile-pic="<?= $users['profile-pic'] ?>">
                                    Ajouter
                                </button>

                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <!-- Le reste masqué -->
            <div id="suggestion-full" class="hidden">

                <?php foreach ($usersList as $users): ?>

                    <div class="suggestion-item bg-white rounded-2xl shadow-md p-4 mb-4 text-sm"
                        data-user-id="<?= $users['unique-id'] ?>">

                        <div class="flex items-center gap-3">
                            <img class="w-13 h-13 object-cover rounded" src="profile-pic/<?= $users['profile-pic'] ?>" alt="">

                            <div class="flex gap-3 flex-col w-full">
                                <strong><?= htmlspecialchars($users['last-name'] . ' ' . $users['first-name']); ?></strong>

                                <button 
                                    class="btn-add-friend w-full rounded-xl px-5 py-2 text-sm whitespace-nowrap cursor-pointer outline-none font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0"
                                    data-user-id="<?= $users['unique-id'] ?>" 
                                    data-user-name="<?= htmlspecialchars($users['last-name'] . ' ' . $users['first-name']) ?>"
                                    data-profile-pic="<?= $users['profile-pic'] ?>">
                                    Ajouter
                                </button>

                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <?php if (count($usersList) > 2): ?>

                <button id="toggle-suggestions"
                    class="px-5 py-2 mb-2 rounded-xl text-sm text-blue-600 bg-gray-100 shadow-[4px_4px_8px_#c5c5c5,_-4px_-4px_8px_#ffffff] hover:shadow-inner border border-blue-500 transition-all cursor-pointer outline-none">
                    <span class="toggle-text-suggested-friends">Voir plus</span>
                </button>

            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>




<script src="assets/js/friends-manager.js"></script>
