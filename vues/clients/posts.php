<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="../../assets/css/output.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-gray-100">
    <!-- Partie de l'entete -->
    <?php require '../../inclusions/header.php' ?>

    <section class="flex items-center justify-center">
        <form method="POST" class="bg-white shadow-lg my-7 rounded-2xl p-6 w-[40vw]">
            <h1 class="text-2xl font-bold mb-4 text-blue-600">Créer une publication</h1>
        
            <div class="flex items-center mb-3">
                <span class="font-bold mr-2">Fayad Ademola</span>
            </div>
                
            <textarea class="w-full rounded-lg resize-none outline-0 shadow p-2 h-32" name="content">Quoi de neuf? Fayad</textarea>
            
            <!-- Section pour ajouter des médias -->
            <div class="flex flex-col items-center justify-center bg-white rounded-lg shadow p-4 mb-4">
                <p class="text-gray-600 mb-3">Ajouter à votre publication</p>
                
                <!-- Boutons d'ajout -->
                <div class="flex justify-around">
                    <!-- Input file caché -->
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
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 float-right rounded outline-0 cursor-pointer">
                Poster
            </button>
        </form>
    </section>



    <script src="../../assets/js/posts.js"></script>
</body>
</html>