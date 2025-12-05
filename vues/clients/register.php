<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Document</title>
</head>

<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen">
  <div class="flex mb-9 justify-center items-center">
     <!-- Logo -->
    <div href="/socialnetwork/home.php" class="flex items-center gap-2">
        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
            <span class="text-white font-bold text-xl">A</span>
        </div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Afrovibe</h1>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow p-7 w-[95%] md:w-full max-w-sm mb-12">

    <form id="multiStepForm" method="POST" enctype="multipart/form-data">
      <div class="mb-3 font-bold text-4xl text-gray-800">Inscription</div>
      <!-- Étape 1: Informations personnelles -->
      <div class="step flex gap-3 flex-col" data-step="1">
          <div>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            name="last-name" placeholder="Nom" class="mb-4" required>
          </div>
          <div>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            name="first-name" placeholder="Prénom" class="mb-4" required>
          </div>
          <div>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            name="email" type="email" placeholder="Email" class="mb-4" required>
          </div>
          <div>
            <textarea class="w-full resize-none px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 h-24 transition" name="bio" placeholder="Bio" class="mb-4 h-24"></textarea>
          </div>
          <div>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            name="password" type="password" placeholder="Mot de passe" class="mb-4" required>
          </div>
          <div>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            name="confirm-password" type="password" placeholder="Confirmer mot de passe" class="mb-4" required>
          </div>
      </div>

      <!-- Étape 2: Sexe et Date de Naissance -->
      <div class="step hidden" data-step="2">
          <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Sexe</label>
            <div id="genderGroup" class="flex gap-3">
              <button type="button" class="w-[33%] gender-option px-4 py-2 rounded-md border border-gray-300 text-gray-600 hover:bg-blue-50 focus:bg-blue-500 focus:text-white outline-0 focus:font-semibold transition cursor-pointer" data-value="homme">
              👨 Homme
              </button>
              <button type="button" class="w-[33%] gender-option px-4 py-2 rounded-md border border-gray-300 text-gray-600 hover:bg-pink-50 focus:bg-pink-500 focus:text-white focus:font-semibold outline-0 transition cursor-pointer" data-value="femme">
              👩 Femme
              </button>
              <button type="button" class="w-[33%] gender-option px-4 py-2 rounded-md border border-gray-300 text-gray-600 outline-0 hover:bg-purple-50 focus:bg-purple-500 focus:text-white focus:font-semibold transition cursor-pointer" data-value="autre">
              🌈 Autre
              </button>
            </div>
            <input type="hidden" class="bg-gray-300 border border-gray-500 text-gray-700" name="gender" required>
          </div>
          <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-2">Date de naissance</label>
              <input type="date" name="birthday" class="px-4 py-2 w-full border border-gray-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
          </div>
      </div>

      <!-- Étape 2: Photo de profil -->
      <div class="step hidden" data-step="3">
        <label class="block text-gray-700 font-medium mb-2">Photo de profil:</label>

        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:border-blue-500 transition" 
          onclick="document.getElementById('profileUpload').click()" 
          ondragover="event.preventDefault()" 
          ondrop="handleDrop(event)">

          <input type="file" name="profile-pic" id="profileUpload" accept="image/*" class="hidden" >

          <div id="previewContainer" class="w-24 h-24 rounded-2xl overflow-hidden bg-gray-200 mb-4">
            <img id="previewImage" src="../../assets/images/defaultProfile.jpeg" class="object-cover w-full h-full" alt="">
          </div>

          <p class="text-gray-500 text-sm">
            Glissez une image ici ou cliquez pour sélectionner un fichier
          </p>
        </div>

        <p id="fileName" class="text-xs text-gray-500 mt-2 italic">Aucune image sélectionnée</p>
      </div>

      <!-- Navigation -->
      <div class="flex justify-between">
        <button type="button" id="prevBtn" class="hidden bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-xl mr-auto mt-3 outline-0 font-semibold text-sm cursor-pointer">Précédent</button>
        <button type="button" id="nextBtn" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-xl ml-auto mt-3 outline-0 font-semibold text-sm cursor-pointer" >Suivant</button>
        <button type="submit" id="submitBtn" class="hidden bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl ml-auto mt-3 outline-0 font-semibold text-sm cursor-pointer">S'inscrire</button>
      </div> 

      <span class="flex justify-center text-center text-gray-600 text-sm mt-7">Déjà membre? <a href="#" class="text-blue-500"> Connectez vous ici</a></span>
    </form>
  </div>


  
  <script src="../../assets/js/register.js"></script>
  
</body>
</html>