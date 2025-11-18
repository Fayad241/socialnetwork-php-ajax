<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-400 to-cyan-400">
          AFRO<span class="font-light">vibe</span>
        </h1>
      </div>
      <div class="relative flex gap-3 items-center justify-between">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 absolute ml-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
        <input class="bg-gray-100 rounded-2xl outline-hidden h-auto py-2 px-3 pl-12 w-76 shadow-sm" type="text" placeholder="Rechercher sur Afrovibe">
        <a class="flex gap-1 items-center justify-center bg-cyan-500 rounded-2xl text-white font-bold py-2 px-3 cursor-pointer" href="vues/clients/posts.php">
          <div class="flex items-center justify-center text-center rounded border px-1 pb-1">
            <p class="flex items-center justify-center text-center w-2 h-3 text-sm">+</p>      
          </div>
          <div>Creer</div>
        </a>
        <div class="relative">
          <svg id="open-notifications" xmlns="http://www.w3.org/2000/svg"
              class="w-10 h-10 text-gray-500 p-[6px] bg-gray-200 rounded-full cursor-pointer"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                    6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67
                    6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595
                    1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-4 h-4 flex items-center justify-center rounded-full">
            3
          </span>

          <!-- UI Affichage Notifications -->
          <div class="absolute border border-gray-200 rounded bg-white px-5 py-2 shadow-lg overflow-y-auto" id="popup-notifications" style="display: none; right: 0; top: 45px; width: 390px; height: 85vh; z-index: 100; padding-right: 40px;">
            <div class="flex flex-col">
              <div class="flex items-center justify-between border-b border-gray-200">
                <div class="flex gap-1 items-center font-bold text-xl">
                  <svg xmlns="http://www.w3.org/2000/svg"
                      class="w-10 h-10 p-[6px] rounded-full mb-2"
                      fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                            6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67
                            6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595
                            1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                  </svg>
                  <p class="mb-2">Notifications</p>
                </div>
                <svg id="close-notifications" class="border border-gray-200 bg-gray-100 flex items-center justify-center rounded-full w-7 h-7 p-1 mb-2 cursor-pointer" xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-6 h-6 text-red-500 hover:text-red-600 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12" />
                </svg>
              </div>
              <div class="my-4">
                <div class="font-bold text-xl">Aujourdhui</div>
                <div class="flex gap-3 my-4">
                  <img class="w-13 h-13 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
                  <div class="flex flex-col gap-1 text-gray-600" style="width: 260px;">
                    <div class="">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia, in? Lorem ipsum dolor sit amet.</div>
                    <div>24min</div>
                  </div>
                </div>
                <div class="flex gap-3 my-4">
                  <img class="w-13 h-13 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
                  <div class="flex flex-col gap-1 text-gray-600" style="width: 260px;">
                    <div class=""><strong class="text-black">ULRICH MORGAN</strong> veut faire partie de vos amis</div>
                    <div>2h</div>
                    <div class="flex gap-6 items-center justify-center my-1">
                      <button class="flex items-center justify-center bg-blue-600 text-white rounded-xl px-5 py-2 text-sm" style="width: 105px;">Accepter</button>
                      <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm" style="width: 105px;">Refuser</button>
                    </div>
                  </div>
                </div>
                <div class="font-bold text-xl">7 derniers jours</div>
                <div class="flex gap-3 my-4">
                  <img class="w-13 h-13 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
                  <div class="flex flex-col gap-1 text-gray-600" style="width: 260px;">
                    <div class="">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia, in? Lorem ipsum dolor sit amet.</div>
                    <div>1j</div>
                  </div>
                </div>
                <div class="flex gap-3 my-4">
                  <img class="w-13 h-13 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
                  <div class="flex flex-col gap-1 text-gray-600" style="width: 260px;">
                    <div class="">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia, in? Lorem ipsum dolor sit amet.</div>
                    <div>3j</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <img class="w-9 h-9 object-cover rounded" src="/socialnetwork/profile-pic/<?=$user['profile-pic']?>" alt="">
        </div>
      </div>
    </div>
  </section>
</body>
</html>