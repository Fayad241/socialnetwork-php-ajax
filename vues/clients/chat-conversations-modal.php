<?php 
    // session_start();
    // require 'inclusions/database.php';

    // if (!isset($_SESSION['user-id'])) {
    //     die(json_encode(['error' => 'Non connecté'])); 
    // }

    // $stmt = $pdo->prepare("SELECT * FROM users WHERE NOT `unique-id` = :user_id");
    // $stmt->execute([':user_id' => $_SESSION['user-id']]);
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // $output = '';

    // if(rowCount($user) == 1) {
    //     $output .= "Aucun utilisateur disponible dans le chat";
    // } else if(rowCount($user) > 0) {
        
    // }
    // echo $output;


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

   <section id="popup-messages" class="absolute hidden justify-center items-center" style="z-index: 200">
    <div class="flex gap-1 flex-col bg-white shadow-lg rounded-2xl px-6 py-5" style="width: 45vw; height:520px; margin: 30px 340px">
        <div class="flex items-center justify-between mb-4">
            <div class="text-blue-600 font-bold text-2xl">Messages</div>
            <svg id="close-messages" class="border border-gray-200 bg-gray-100 flex items-center justify-center rounded-full w-7 h-7 p-1 mb-2 cursor-pointer" xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                    class="w-6 h-6 text-red-500 hover:text-red-600 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-6 h-6 text-gray-500 ml-4 top-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input class="bg-gray-100 rounded-2xl outline-hidden h-auto py-2 px-3 pl-12 w-80 shadow-lg" type="text" placeholder="Rechercher...">
        </div>
        <div class="flex gap-1 flex-col my-6 overflow-y-auto users-list">
           
        </div>
    </div>
   </section>



   <script src="../../assets/js/chat-conversations-modal.js"></script>
</body>
</html>