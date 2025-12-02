<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
  <header class="hidden lg:block">
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
        <a href="/socialnetwork/home.php" class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-400 to-cyan-400 outline-none">
          AFRO<span class="font-light">vibe</span>
        </a>
      </div>
      <div class="relative flex gap-3 items-center justify-between">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 absolute ml-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
        <input class="bg-gray-100 rounded-2xl outline-hidden h-auto py-2 px-3 pl-12 w-76 shadow-sm" type="text" placeholder="Rechercher sur Afrovibe">
        <a class="flex gap-1 items-center justify-center bg-[#06B6D4] rounded-2xl text-white font-bold py-2 px-3 cursor-pointer" href="/socialnetwork/vues/clients/posts.php">
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
  </header>


  <!-- Version Mobile (visible uniquement sur mobile) -->
  <section class="lg:hidden flex flex-col">
    <!-- Header mobile -->
    <header class="border-b border-gray-200 p-4 sticky top-0 z-50">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-xl">A</span>
                </div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Afrovibe</h1>
            </div>
            
            <!-- Icônes à droite -->
            <div class="flex items-center gap-3">
                <!-- Recherche -->
                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Notifications -->
                <button class="p-2 hover:bg-gray-100 rounded-full relative">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">12</span>
                </button>
                
                <!-- Menu burger -->
                <button onclick="" class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>
  </section>


</body>
</html>