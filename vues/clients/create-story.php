<?php 

    require '../../inclusions/check_session.php';

    $current_user = $_SESSION['user_id'];

    if (!isset($current_user)) {
        header("Location: login.php"); 
    }

    $sql = $pdo->prepare("SELECT * FROM users WHERE `unique-id` = :user_id");
    $sql->execute([':user_id' => $current_user]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="../../assets/css/output.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-gray-50">

    <!-- Partie de l'entete -->
    <?php require '../../inclusions/header.php' ?>
    
    <section id="add-story-modal" class="flex items-center justify-center">
        <div class="bg-white md:shadow-sm md:my-7 my-12 mx-3 p-6 rounded-2xl md:w-[65vw] lg:w-[40vw] w-full overflow-hidden">
           
            <h1 class="text-2xl font-bold mb-4 text-blue-600">Créer une story</h1> 
            <div class="flex gap-1.5 items-center mb-3">
                <i class="fa-solid fa-user"></i>
                <span class="font-bold mr-2"><?= $user['first-name'] . ' ' . $user['last-name'] ?></span>
            </div>

            <div id="post-error" class="text-red-500 text-sm mt-2 hidden"></div>
            <div class="py-6">
                <!-- Texte -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-3">✍️ Ecrire du texte</label>
                    <textarea id="story-text" rows="3" maxlength="200" 
                    placeholder="Quoi de neuf <?= $user['last-name'] ?> ?" 
                    class="w-full h-32 rounded-lg resize-none outline-0 py-3 px-4 border-2 border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>

                    <p class="text-xs text-gray-500 mt-1"><span id="text-count">0</span>/200</p>
                </div>

                <label class="block text-sm font-bold text-gray-700 mb-3">📸 Photo ou vidéo</label>
                <div class="relative">
                <div class="flex flex-col items-center justify-center bg-white rounded-lg border-2 border-gray-300 p-4 mb-4">
                    <p class="text-gray-600 mb-3">Ajouter à votre story</p>
                
                
                    <div class="flex justify-around">                  
                        <input type="file" id="story-media" class="hidden" accept="image/*,video/*">
                        
                        <!-- Bouton pour déclencher l'upload -->
                        <button type="button" onclick="document.getElementById('story-media').click()" class="text-gray-600 flex flex-col items-center justify-center  cursor-pointer outline-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs">Photo</span>
                        </button>
                    </div>
                
                    <!-- Zone d'affichage de l'image -->
                    <div id="preview-box" class="mt-3 hidden">
                        <img id="preview-image" src="" class="max-h-60 w-full object-cover rounded-lg hidden">
                        <video id="preview-video" controls class="max-h-60 w-full rounded-lg hidden"></video>
                    </div>
                </div>

                <!-- Durée de la story -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-3">⏱️ Durée de visibilité</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="duration" value="6" class="peer hidden">
                            <div class="border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-xl p-4 text-center transition-all hover:border-blue-400">
                                <p class="font-bold text-lg text-gray-800">6h</p>
                                <p class="text-xs text-gray-500">Court</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="duration" value="12" class="peer hidden">
                            <div class="border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-xl p-4 text-center transition-all hover:border-blue-400">
                                <p class="font-bold text-lg text-gray-800">12h</p>
                                <p class="text-xs text-gray-500">Moyen</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="duration" value="24" class="peer hidden" checked>
                            <div class="border-2 border-blue-600 bg-blue-50 rounded-xl p-4 text-center transition-all">
                                <p class="font-bold text-lg text-gray-800">24h</p>
                                <p class="text-xs text-gray-500">Standard</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button  
                        class="btn-publish-story w-full bg-gradient-to-r from-blue-600 to-[#06B6D4] text-white font-bold py-3 rounded-lg hover:shadow-lg transition-all outline-none cursor-pointer"
                        id="publish-btn"
                        >
                    Publier la story
                </button>
            </div>
        </div>
        
    </section>



    <script src="../../assets/js/create-story.js"></script>
</body>
</html>