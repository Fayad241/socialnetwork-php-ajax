<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
     <section>
    <div class="flex items-center justify-between py-3 px-8 border-b border-gray-200">
      <div class="flex gap-[1px] items-center">
        <svg width="42" height="40" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="blueGradient" x1="0" y1="0" x2="1" y2="0">
              <stop offset="0%" stop-color="#2563EB" />   
              <stop offset="50%" stop-color="#3B82F6" />  
              <stop offset="100%" stop-color="#06B6D4" /> 
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
        <a href="/socialnetwork/home.php" class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-400 to-cyan-400">
          AFRO<span class="font-light">vibe</span>
        </a>
      </div>
      <div class="relative flex gap-3 items-center justify-between">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 absolute ml-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
        <input class="bg-gray-100 rounded-2xl outline-hidden h-auto py-2 px-3 pl-12 w-76 shadow-sm" type="text" placeholder="Rechercher sur Afrovibe">
        <a class="flex gap-1 items-center justify-center bg-cyan-500 rounded-2xl text-white font-bold py-2 px-3 cursor-pointer" href="/socialnetwork/vues/clients/posts.php">
          <div class="flex items-center justify-center text-center rounded border px-1 pb-1">
            <p class="flex items-center justify-center text-center w-2 h-3 text-sm">+</p>      
          </div>
          <div>Creer</div>
        </a>
        
          <!-- Partie affichage notifications et icone -->
          <?php require 'components/sectionNotification.php' ?>

        <div>
          <img class="w-9 h-9 object-cover rounded" src="/socialnetwork/profile-pic/<?=$user['profile-pic']?>" alt="">
        </div>
      </div>

    </div>
  </section>
</body>
</html>