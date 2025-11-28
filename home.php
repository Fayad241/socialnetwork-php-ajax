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
  <section id="chat-container" class="absolute hidden justify-center items-center" style="z-index: 200">
    
    <div class="chat-place flex gap-1 flex-col bg-white shadow-lg rounded-2xl" style="width: 35vw; height:520px; margin: 35px 420px">  
        
    </div>
  </section> 

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
      <form method="POST" action="" class="form-post my-8">
          <div id="post-error" class="text-red-500 text-sm mb-1 hidden"></div>
          <div class="flex items-center justify-between bg-white w-full rounded-2xl shadow-md px-4 py-3">
            <div class="flex gap-3 items-center">
              <img class="w-14 h-14 rounded object-cover" src="profile-pic/<?=$user['profile-pic']?>" alt="">
              <textarea 
                class="text-post w-96 flex h-full outline-none text-gray-900 px-2" 
                name="content" 
                placeholder="Quoi de neuf, <?= $user['first-name']?> ?"
              ></textarea>
            </div>
            <button class="bg-cyan-500 ml-1 w-24 px-3 py-2 text-white rounded-xl text-sm font-bold outline-none cursor-pointer">
              
              Publier
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

        <div class="flex flex-col gap-4 bg-white rounded-2xl shadow-lg py-5 px-6">

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
  <nav class="flex lg:hidden bg-white border-t border-gray-200 p-2 sticky bottom-0 z-50">
    <div class="flex justify-between gap-8 items-center">
        <a href="/socialnetwork/home.php" class="flex flex-col items-center gap-1 p-2 text-blue-600">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
            <span class="text-[10px] font-medium">Accueil</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 p-2 text-gray-500">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
            </svg>
            <span class="text-[10px] font-medium">Amis</span>
        </a>
        <a href="/socialnetwork/vues/clients/posts.php" class="flex flex-col items-center -mt-5">
            <div class="bg-gradient-to-r from-cyan-400 to-purple-600 rounded-full p-3 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
        </a>
        <a href="#" id="open-messages" class="flex flex-col items-center gap-1 p-2 text-gray-500">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
            </svg>
            <span class="text-[10px] font-medium">Messages</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 p-2 text-gray-500">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>
  </nav>




  <script src="assets/js/index.js"></script>
  <script src="assets/js/chat-conversations-modal.js"></script>
  <script src="assets/js/logout.js"></script>

</body>
</html>