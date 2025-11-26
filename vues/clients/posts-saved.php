<?php 
    session_start();

    require '../../inclusions/database.php';

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

    <div>
        <div class="px-6 pt-5 pb-3 sticky top-0 z-20">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold flex items-center gap-2">
                    <span class="text-blue-500">★</span>  
                    Posts enregistrés
                </h1>

                <a href="../../home.php" class="text-blue-500 hover:underline text-sm">
                    ← Retour
                </a>
            </div>

            <p class="text-gray-500 text-sm mt-1">Voici tous les posts que vous avez sauvegardés.</p>
        </div>
    
        <div class="flex justify-center overflow-hidden">
            <!-- <div class="flex gap-3 flex-col my-3 w-full h-[69vh] overflow-y-auto scrollbar-custom" style="padding: 0 30px; width: 350px;">
                <?php require '../../inclusions/components/side-bar.php' ?>
            </div> -->

            <div id="saved-posts-container" data-author-id="<?= $_SESSION['user_id'] ?>" class="flex flex-col my-3 gap-6 overflow-y-auto scrollbar-custom w-[45vw] h-[70vh]">
                
               <!-- Affichage des posts -->
            </div>
        </div>
    </div>



<script src="../../assets/js/posts-saved.js"></script>
</body>
</html>