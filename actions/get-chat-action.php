<?php
  session_start();
  require '../inclusions/database.php';
  require '../inclusions/functions.php';

  // Vérifications de sécurité
  if (!isset($_SESSION['user_id'])) {
      die("<div class='error'>Non connecté</div>");
  }

  if (empty($_GET['contact_id'])) {
      die("<div class='error'>ID contact manquant</div>");
  }

  $current_user = $_SESSION['user_id'];
  $contact_id = $_GET['contact_id'];

  // Récupère les infos du contact
  $stmtContact = $pdo->prepare("SELECT * FROM users WHERE `unique-id` = :contact_id");
  $stmtContact->execute([':contact_id' => $contact_id]);
  $contact = $stmtContact->fetch(PDO::FETCH_ASSOC);

  // Récupère les messages
  $stmt = $pdo->prepare("
      SELECT * FROM messages 
      WHERE (`sender-msg-id` = :current_user AND `receiver-msg-id` = :contact_id)
      OR (`sender-msg-id` = :contact_id AND `receiver-msg-id` = :current_user)
      ORDER BY `date-send` ASC
  ");
  $stmt->execute([':current_user' => $current_user, ':contact_id' => $contact_id]);


  // Calculer le statut de l'utilisateur
  $status = getUserStatus($contact['last-activity']);

  $output = '';

  // EN-TÊTE DE LA CONVERSATION
  $output .= '<div class="flex items-center justify-between shadow-sm w-full p-4">
      <div class="flex items-center gap-3">
          <svg id="back-to-list" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cursor-pointer hover:text-gray-700 transition-colors">
              <line x1="19" y1="12" x2="5" y2="12"></line>
              <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          <div class="relative">
              <img class="rounded-full object-cover" src="profile-pic/'.(isset($contact['profile-pic']) ? htmlspecialchars($contact['profile-pic']) : 'defaultProfile.jpeg').'" alt="" style="width: 50px; height: 50px">
              <div class="'.$status['class'].' absolute w-3 h-3 rounded-full border-2 border-white top-9 left-10"></div>
          </div>
          <div>
              <strong>'. htmlspecialchars($contact['last-name'] .' '.$contact['first-name']) .'</strong>
              <p class="text-gray-600">'.$status['text'].'</p>
          </div>
      </div>
  </div>';

  // ZONE DE MESSAGES
  $output .= '<div class="messages-zone h-full overflow-y-auto p-3" id="messages-zone">';

  if($stmt->rowCount() > 0) {
      while($message = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $messageText = htmlspecialchars($message['msg']);
          $messageTime = date('H:i', strtotime($message['date-send']));
          
          // Message envoyé par l'utilisateur courant
          if($message['sender-msg-id'] == $current_user) {
              $output .= '<div class="message-item flex gap-1 flex-col bg-blue-500 text-white rounded-xl my-2 p-2 ml-auto w-[85%]">
                  <div>'.$messageText.'</div>
                  <div class="message-time text-sm text-right font-semibold">'.$messageTime.'</div>
              </div>';
          }
          // Message reçu
          else {
              $output .= '<div class="message-item flex gap-3 bg-gray-100 text-gray-500 rounded-xl my-2 p-2 mr-auto w-[85%]">
                  <img class="object-cover rounded-full" src="profile-pic/'.(isset($contact['profile-pic']) ? htmlspecialchars($contact['profile-pic']) : 'defaultProfile.jpeg').'" alt="" style="width: 45px; height: 45px">
                  <div class="flex gap-1 flex-col">
                      <div>'.$messageText.'</div>
                      <div class="message-time text-sm text-left font-semibold">'.$messageTime.'</div>
                  </div>
              </div>';
          }
      }
  } else {
      $output .= '<div class="text-center text-gray-500 mt-10">Aucun message. Démarrez la conversation !</div>';
  }

  $output .= '</div>'; 

  // CHAMP DE SAISIE
  $output .= '
  <div class="flex bg-gray-50 rounded-bl-2xl rounded-br-2xl gap-3 items-center w-full mt-auto border-t border-gray-200">
      <div class="">
          <input type="hidden" id="receiver-id" value="'.htmlspecialchars($contact_id).'">
          <textarea id="message-text" class="bg-gray-50 rounded-bl-2xl outline-0 resize-none w-96 py-2 px-3" placeholder="Entrer un message"></textarea>
      </div>
      <button id="send-message-btn" type="button" class="flex justify-center items-center rounded-full bg-blue-500 hover:bg-blue-600 p-2 transition-colors outline-none">
          <svg class="w-6 h-6 text-white" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2.94 2.94a1.5 1.5 0 0 1 1.58-.35l12 4.5a1.5 1.5 0 0 1 0 2.82l-12 4.5A1.5 1.5 0 0 1 2 13.06V11l8-1-8-1V2.94z"/>
          </svg>
      </button>
  </div>';

  echo $output;
?>