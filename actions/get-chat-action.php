<?php
session_start();
session_regenerate_id(true);
require '../inclusions/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) die(json_encode(['error' => 'Non connecté']));
if (!isset($_GET['contact_id'])) die(json_encode(['error' => 'Contact manquant']));

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

// Génère le HTML de la conversation
$output = '';
// if($stmt->rowCount() > 0) {
    while($message = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Le message envoyé
        if($message['sender-msg-id'] == $current_user) {
            $output .= '<div class="flex gap-1 flex-col bg-blue-100 text-gray-600 rounded-xl my-2 p-2  shadow-sm" style="margin-left: auto; width: 375px; margin-right: 12px">
            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, corrupti? Lorem ipsum dolor sit.</div>
            <div class="text-sm">19:02</div>
          </div>
';
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
// }

echo $output;

?>