<?php
session_start();
session_regenerate_id(true);
require '../inclusions/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_log("Données reçues: " . print_r($_POST, true));
error_reporting(E_ALL);

// Debug: Log toutes les entrées
error_log("GET: " . print_r($_GET, true));
error_log("SESSION: " . print_r($_SESSION, true));

// Validation
if (!isset($_SESSION['user_id'])) {
  die("<div class='error'>Non connecté</div>");
}

if (empty($_GET['contact_id'])) {
  die("<div class='error'>ID contact manquant</div>");
}

$current_user = $_SESSION['user_id'];
$contact_id = $_GET['contact_id'];

// Récupère les messages entre les 2 utilisateurs
$stmt = $pdo->prepare("
    SELECT * FROM messages 
    WHERE (`sender-msg-id` = :current_user AND `receiver-msg-id` = :contact_id)
    OR (`sender-msg-id` = :contact_id AND `receiver-msg-id` = :current_user)
    ORDER BY `date-send` ASC
");
$stmt->execute([':current_user' => $current_user, ':contact_id' => $contact_id]);


$output = '';
$output .= ' <div class="flex items-center justify-between shadow-sm w-full p-4">
        <div class="flex items-center gap-3">
            <svg id="back-to-list" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left cursor-pointer hover:text-gray-700 transition-colors">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <div class="relative">
              <img class="rounded-full object-cover" src="assets/images/img_user_publicaton.jpg" alt="" style="width: 50px; height: 50px">
              <div class="absolute w-3 h-3 bg-green-500 rounded-full border-2 border-white" style="right: -1px; bottom: 3px"></div>
            </div>
            <div>
                <strong>Junior Rice</strong>
                <p class="text-gray-600">en ligne</p>
            </div>
        </div>
    </div> ';


// HTML des conversations
$output .= '<div class="h-full">';
if($stmt->rowCount() > 0) {
    while($message = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Le message envoyé
        if($message['sender-msg-id'] == $current_user) {
            $output .= '<div class="flex gap-1 flex-col bg-blue-100 text-gray-600 rounded-xl my-2 p-2  shadow-sm" style="margin-left: auto; width: 375px; margin-right: 12px">
            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, corrupti? Lorem ipsum dolor sit.</div>
            <div class="text-sm">19:02</div>
          </div> ';
        }
        // Le message recu 
        else {
            $output .= '<div class="flex gap-3 bg-gray-100 text-gray-600 rounded-xl my-2 p-2 shadow-sm" style="margin-right: auto; width: 375px; margin-left: 12px">
            <img class="object-cover rounded-full" src="assets/images/img_user_publicaton.jpg" alt="" style="width: 60px; height: 45px">
            <div class="flex gap-1 flex-col" style="width: 400px;">
              <div>Lorem ipsum dolor sit amet consectetur adipisici</div>
              <div class="text-sm">19:02</div>
            </div>
          </div>';
        }
    } 
}
$output .= '</div>'; 

// Champ de saisi du message
$output .= '
    <div class="flex gap-2 items-center mb-1 w-full mt-auto" style="margin: 0 10px">
        <div class="relative">
          <input type="hidden" id="sender-id" value="'.$_SESSION['user_id'].'">
          <input type="hidden" id="receiver-id" value="'.htmlspecialchars($_GET['contact_id'] ?? '').'">
          <textarea id="message-text" class="bg-gray-200 rounded-xl mb-2 outline-0 resize-none" style="height: 44px; width: 30vw; padding: 10px 12px;" placeholder="Entrer un message"></textarea>
          <svg class="absolute w-4 h-4 font-bold text-gray-600" style="right: 16px; bottom: 19px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          </svg>
      </div>
      <div>
          <button id="send-message-btn" type="button" class="flex justify-center items-center rounded-full bg-gray-400 p-2 mb-2">
            <svg  class="w-6 h-6 text-gray-400 hover:text-green-500 cursor-pointer transition-colors duration-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.7639 12H10.0556M3 8.00003H5.5M4 12H5.5M4.5 16H5.5M9.96153 12.4896L9.07002 15.4486C8.73252 16.5688 8.56376 17.1289 8.70734 17.4633C8.83199 17.7537 9.08656 17.9681 9.39391 18.0415C9.74792 18.1261 10.2711 17.8645 11.3175 17.3413L19.1378 13.4311C20.059 12.9705 20.5197 12.7402 20.6675 12.4285C20.7961 12.1573 20.7961 11.8427 20.6675 11.5715C20.5197 11.2598 20.059 11.0295 19.1378 10.5689L11.3068 6.65342C10.2633 6.13168 9.74156 5.87081 9.38789 5.95502C9.0808 6.02815 8.82627 6.24198 8.70128 6.53184C8.55731 6.86569 8.72427 7.42461 9.05819 8.54246L9.96261 11.5701C10.0137 11.7411 10.0392 11.8266 10.0493 11.9137C10.0583 11.991 10.0582 12.069 10.049 12.1463C10.0387 12.2334 10.013 12.3188 9.96153 12.4896Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
          </button>
      </div>
    </div>';

    
echo $output;

?>