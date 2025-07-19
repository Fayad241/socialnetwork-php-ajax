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
    <!-- <link href="../../assets/css/register.css" rel="stylesheet"> -->
    <title>Document</title>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
  <!-- Logo et nom de l'application -->
  <div class="flex mb-3 justify-center items-center">
    <svg width="44" height="44" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="blueGradient" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0%" stop-color="#2563EB" />   <!-- blue-600 -->
            <stop offset="50%" stop-color="#3B82F6" />  <!-- blue-500 -->
            <stop offset="100%" stop-color="#06B6D4" /> <!-- cyan-400 -->
          </linearGradient>
        </defs>
        <!-- Spiral circle -->
        <g transform="translate(10, 10)">
          <circle cx="30" cy="30" r="28" stroke="url(#blueGradient)" stroke-width="4" fill="none"/>
          <path d="
            M30 30
            m0 -20
            a20 20 0 1 1 -20 20
            a10 10 0 1 0 10 -10
          " fill="none" stroke="url(#blueGradient)" stroke-width="2"/>
        </g>
    </svg>
    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-400 to-cyan-400">
      AFRO<span class="font-light">vibe</span>
    </h1>
  </div>

  <div class="bg-white rounded-2xl shadow-sm p-7 w-full max-w-lg mb-12">

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

      <span class="flex justify-center text-center text-gray-600 text-sm">Déjà membre? <a href="#" class="text-blue-500"> Connectez vous ici</a></span>
    </form>
  </div>


  
  <script src="../../assets/js/register.js"></script>
  
</body>
</html>