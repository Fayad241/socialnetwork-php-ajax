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

    <section class="flex items-center justify-center">
        <form method="POST" class="form-post bg-white shadow-sm my-7 rounded-2xl p-6 w-[40vw]">
            <h1 class="text-2xl font-bold mb-4 text-blue-600">Créer une publication</h1>
            
            <div class="flex gap-1.5 items-center mb-3">
                <i class="fa-solid fa-user"></i>
                <span class="font-bold mr-2"><?= $user['first-name'] . ' ' . $user['last-name'] ?></span>
            </div>

            <div id="post-error" class="text-red-500 text-sm mt-2 hidden"></div>
                
            <div class="mb-4 mt-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">✍️ Ecrire du texte</label>
                <textarea class="w-full rounded-lg resize-none outline-0 py-3 px-4 h-32 border-2 border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-transparent" name="content" placeholder="Quoi de neuf <?= $user['last-name'] ?> ?" ></textarea>
            </div>
            
            <label class="block text-sm font-bold text-gray-700 mb-2">📸 Photo ou vidéo</label>
            <div class="flex flex-col items-center justify-center bg-white rounded-lg border-2 border-gray-300 p-4 mb-4">
                <p class="text-gray-600 mb-3">Ajouter à votre publication</p>
                
                
                <div class="flex justify-around">
                
                    <input type="file" id="image-upload" name="img-publication" class="hidden" accept="image/*">
                    
                    <!-- Bouton pour déclencher l'upload -->
                    <button type="button" onclick="document.getElementById('image-upload').click()" class="text-gray-600 flex flex-col items-center justify-center  cursor-pointer outline-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs">Photo</span>
                    </button>
                </div>
                
                <!-- Zone d'affichage de l'image -->
                <div id="image-preview" class="mt-3 hidden">
                    <img id="preview" src="" class="max-h-60 w-full object-cover rounded-lg">
                </div>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-[#06B6D4] text-white font-bold py-3 rounded-lg hover:shadow-lg transition-all cursor-pointer">
                Poster 
            </button>
        </form>
    </section>



    <script src="../../assets/js/posts.js"></script>
</body>
</html>