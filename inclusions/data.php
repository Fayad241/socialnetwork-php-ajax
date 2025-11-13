<?php 
while($user = $sql->fetch(PDO::FETCH_ASSOC)) {

    $sql2 = $pdo->prepare("
        SELECT * FROM messages 
        WHERE ((`receiver-msg-id` = :contact_id AND `sender-msg-id` = :current_user) 
        OR (`sender-msg-id` = :contact_id AND `receiver-msg-id` = :current_user))
        ORDER BY id DESC LIMIT 1
    ");
    $sql2->execute([
        ':contact_id' => $user['unique-id'],
        ':current_user' => $current_user
    ]);
    
    $row = $sql2->fetch(PDO::FETCH_ASSOC);
    
    $msg = "Aucun message";
    $you = "";
    $date_display = "";
    $showNotification = false;
    
    // Si un message existe
    if($row && $sql2->rowCount() > 0) {
        $result = $row['msg'];
        
        // Afficher les 28 premiers caractères si le message est long
        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;
        
        $you = ($current_user == $row['sender-msg-id']) ? "Vous: " : "";
        
        $date_display = date('H:i', strtotime($row['date-send']));

        if($row['sender-msg-id'] == $user['unique-id']) {
            $showNotification = true;
        }
    }
    
    // Calculer le statut de l'utilisateur
    $status = getUserStatus($user['last-activity']);
    
    $output .= '<div class="flex justify-between my-4 cursor-pointer user-item" data-user-id="'.$user['unique-id'].'">
        <div class="flex gap-4">
            <div class="relative">
                <img class="w-13 h-13 rounded object-cover" src="profile-pic/'. htmlspecialchars($user['profile-pic']) .'" alt="">
                <div class="'.$status['class'].' absolute w-3 h-3 rounded-full border-2 border-white" style="right: -5px; bottom:15px"></div>
            </div>
            <div>
                <strong>'. htmlspecialchars($user['last-name']) .' '.htmlspecialchars($user['first-name']).'</strong>
                <p class="text-gray-600">'. $you .' '. htmlspecialchars($msg) .'</p>
            </div>
        </div>
        <div class="flex gap-2 flex-col items-center">';
            if($date_display) {
                $output .= '<p class="text-gray-600">'. $date_display .'</p>';
            }
            if($showNotification) {
                $output .= '<div class="bg-blue-500 w-3 h-3 rounded-full animate-pulse"></div>';
            }
        $output .= '</div>
    </div>';
}
?>