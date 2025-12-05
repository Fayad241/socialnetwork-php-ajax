<?php 
  require 'inclusions/check_session.php';

  $current_user = $_SESSION['user_id'];

  if (!isset($current_user)) {
    header("Location: vues/clients/login.php"); 
  }

  // Requete pour afficher les informations personnelles de l'utilisateur
  $stmt = $pdo->prepare("SELECT * FROM users WHERE `unique-id` = :user_id");
  $stmt->execute([':user_id' => $current_user]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Requete pour afficher les informations des autres utilisateurs
  $stmt5 = $pdo->prepare("SELECT * FROM users WHERE NOT `unique-id` = :user_id");
  $stmt5->execute([':user_id' => $current_user]); 


?>





<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="assets/css/output.css" rel="stylesheet">
</head>
<body class="relative bg-gray-50 overflow-hidden">

  <div class="relative">
    <?php require 'vues/clients/chat-conversations-modal.php' ?>
  </div>

  <!-- Modal de chat de conversation  -->
  <!-- VERSION LAPTOP -->
  <section id="chat-container" class="absolute hidden justify-center items-center" style="z-index: 200">
    
    <div class="chat-place flex gap-1 flex-col bg-white shadow-lg rounded-2xl" style="width: 35vw; height:520px; margin: 35px 420px">  
        
    </div>
  </section> 

  <!-- VERSION MOBILE -->
  <div id="chat-view-mobile" class="relative hidden flex flex-col h-screen bg-white">
    <!-- Header conversation -->
    <header class="bg-white border-b border-gray-200 px-4 py-3 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <button onclick="backToConversations()" class="p-2 hover:bg-gray-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="relative">
                <img id="chat-user-pic" class="w-14 h-14 rounded-full object-cover" src="" alt="">
                <div id="chat-user-status" class="absolute w-3 h-3 rounded-full border-2 border-white"></div>
            </div>
            <div class="flex-1">
                <h2 id="chat-user-name" class="font-bold text-gray-900"></h2>
                <p id="chat-user-status-text" class="text-xs text-gray-500"></p>
            </div>
            <button class="p-2 hover:bg-gray-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
            </button>  
        </div>
    </header>

    <!-- Zone messages -->
    <div id="messages-zone-mobile" class="overflow-y-auto p-4 space-y-3 h-[75vh]">
        <!-- Messages seront injectés ici -->
    </div>

    <!-- Zone de saisie -->
    <div class="absolute bg-white bottom-19 left-0 w-full border-t border-gray-200 p-4">
        <div class="flex items-end gap-2">
            <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <textarea id="message-input-mobile" 
                      placeholder="Message..." 
                      rows="1"
                      class="flex-1 resize-none bg-gray-100 rounded-2xl px-4 py-2 max-h-32 focus:outline-none focus:ring-2 focus:ring-blue-500 h-full"></textarea>
            <button id="send-btn-mobile" class="bg-blue-500 hover:bg-blue-600 p-2.5 rounded-full transition-colors">
                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.94 2.94a1.5 1.5 0 0 1 1.58-.35l12 4.5a1.5 1.5 0 0 1 0 2.82l-12 4.5A1.5 1.5 0 0 1 2 13.06V11l8-1-8-1V2.94z"/>
                </svg>
            </button>
        </div>
    </div>
  </div>

  <!-- Partie de l'entete -->
  <?php require 'inclusions/header.php' ?>

  <section class="content-container flex justify-center">
    <!-- Partie side-bar et invitations (zone gauche) -->
    <div class="hidden gap-3 flex-col my-3 w-full overflow-y-auto scrollbar-custom lg:flex"   style="padding: 0 30px; height: 85vh; width: 350px;">
      <?php require 'inclusions/components/side-bar.php' ?>
    </div>


    <!-- Fil d'actualités -->
    <div class="my-3 mx-1.5 lg:mx-0 overflow-y-auto scrollbar-custom w-[560px] h-[85vh]">
      
      <!-- Stories des utilisateurs -->
      <?php require 'inclusions/components/sectionStories.php' ?>

      <!-- Faire une publication rapide -->
      <form method="POST" action="" class="form-post my-6">
        <div id="post-error" class="text-red-500 text-sm mb-1 hidden"></div>

        <div class="flex items-center bg-white w-full rounded-2xl shadow-sm px-4 py-3 gap-2">

          <div class="flex items-start sm:items-center gap-3 w-full">
            <img 
              class="w-10 h-10 sm:w-14 sm:h-14 rounded object-cover flex-shrink-0"
              src="profile-pic/<?= $user['profile-pic'] ?>" 
              alt=""
            >

            <textarea
              class="text-post flex-1 min-h-[60px] max-h-36 w-full resize-none outline-none text-gray-900 px-2"
              name="content"
              placeholder="Quoi de neuf, <?= $user['first-name'] ?> ?"
            ></textarea>
          </div>

          <button 
            class="bg-[#06B6D4] sm:ml-1 p-3 text-white rounded-full text-sm font-bold outline-none ml-auto cursor-pointer"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
            </svg>
          </button>
        </div>
      </form>


      <!-- Publications et Posts des utilisateurs -->
      <?php require 'inclusions/components/usersPosts.php' ?>
      
    </div>

    <!-- Partie invitations, suggestions, contacts -->
    <div class="hidden gap-5 flex-col my-3 w-full overflow-y-auto scrollbar-custom lg:flex" style="padding: 0 30px;height: 87vh; width: 350px;">
       
      <!-- Invitations, suggestions -->
      <?php require 'inclusions/components/friendsManager.php' ?>


      <!-- Contacts -->
      <div class="mb-5">
        <div class="flex items-center justify-between mb-2">
          <div class="text-gray-800 font-semibold tracking-wide text-sm">
            CONTACTS 
          </div>    

          <div class="bg-blue-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
            <?= $stmt5->rowCount() ?>
          </div>
        </div>

        <div class="flex flex-col gap-4 bg-white rounded-2xl shadow-sm py-5 px-6">

          <?php while($fetch = $stmt5->fetch(PDO::FETCH_ASSOC)) { ?> 
            l<!-- Calculer le statut de l'utilisateur -->
            <?php $status = getUserStatus($fetch['last-activity']); ?>

            <div class="flex items-center justify-between">
              
              <!-- Infos utilisateur -->
              <div class="flex items-center gap-3">
                <img 
                  class="w-11 h-11 rounded-xl object-cover ring-2 ring-gray-200" 
                  src="profile-pic/<?=$fetch['profile-pic']?>" 
                  alt=""
                >
                <strong class="text-gray-800 text-sm">
                  <?= htmlspecialchars($fetch['last-name'] . ' ' . $fetch['first-name']); ?>
                </strong>
              </div>

              <!-- Indicateur en ligne ou non -->
              <div class="relative">
                <span class="<?= $status['class'] ?> absolute inline-block h-3 w-3 rounded-full shadow-sm"></span>
              </div>

            </div>

          <?php } ?>

        </div>
      </div>

    </div>

  </section>



  <!-- Navigation bottom mobile -->
  <?php require 'inclusions/components/mobileNavigation.php' ?>




  <script src="assets/js/index.js"></script>
  <script src="assets/js/chat-conversations-modal.js"></script>
  <script src="assets/js/logout.js"></script>

</body>
</html>