<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <!-- Statut(story) des utilisateurs -->
    <div class="flex gap-4 items-center w-full overflow-x-auto scrollbar-custom" style="scroll-behavior: smooth;">
        <!-- Ajouter une story -->
        <a href="vues/clients/create-story.php" class="relative flex flex-col items-center justify-end cursor-pointer" 
            style="flex: 0 0 auto; width: 135px; height: 210px">
            <!-- Background dégradé -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-400 via-[#06B6D4] to-purple-600 rounded-2xl"></div>
            
            <div class="relative flex flex-col items-center justify-center pb-3 z-10">
                <div class="flex items-center justify-center rounded-full border-4 border-white w-10 h-10 mb-2 bg-white shadow-lg hover:scale-106 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <p class="font-bold text-white text-sm drop-shadow-lg">Créer une story</p>
            </div>
        </a>

        <!-- Stories des utilisateurs -->
        <div id="stories-container" class="flex gap-4">
            <!-- Affichage des stories -->
        </div>

    </div>

    <!-- Modal pour voir une story -->
    <div id="view-story-modal" class="hidden fixed inset-0 z-[9999] bg-black">
        <div class="relative w-full h-full flex items-center justify-center">
            <!-- Barre de progression -->
            <div class="absolute top-4 left-0 right-0 px-4 z-10">
                <div class="flex gap-1">
                    <div id="story-progress" class="flex-1 h-1 bg-white/30 rounded-full overflow-hidden">
                        <div id="story-progress-bar" class="h-full bg-white transition-all duration-100" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Header avec info utilisateur -->
            <div class="absolute top-8 left-4 right-4 flex items-center justify-between z-10">
                <div class="flex items-center gap-3">
                    <img id="story-user-pic" class="w-10 h-10 rounded-full border-2 border-white" src="" alt="">
                    <div>
                        <p id="story-user-name" class="text-white font-bold text-sm"></p>
                        <p id="story-time" class="text-white/80 text-xs"></p>
                    </div>
                </div>
                <button onclick="closeViewStoryModal()" class="text-white hover:bg-white/20 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Conteneur pour image -->
            <img id="story-view-image" class="max-w-full max-h-full object-contain hidden" src="" alt="">
            
            <!-- Conteneur pour vidéo -->
            <video id="story-view-video" class="max-w-full max-h-full object-contain hidden" controls autoplay>
                <source src="" type="video/mp4">
            </video>

            <!-- Texte de la story -->
            <div id="story-view-text" class="absolute bottom-20 left-0 right-0 px-6 hidden">
                <p class="text-white text-center text-lg font-medium drop-shadow-lg"></p>
            </div>

            <!-- Navigation -->
            <button onclick="previousStory()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:bg-white/20 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button onclick="nextStory()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:bg-white/20 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>





    <script src="/socialnetwork/assets/js/sectionStories.js"></script>
</body>
</html>