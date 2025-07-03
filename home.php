<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/output.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
  html, body {
    height: auto !important;
    overflow-y: auto !important;
  }
</style>
</head>
<body class="bg-gray-50" style="height: 100%;
  overflow-y: auto !important;
  margin: 0;
  padding: 0;">

  <?php require 'vues/clients/chat-user-modal.php' ?>

  <!-- Partie de l'entete -->
  <section>
    <div class="flex items-center justify-between py-3 px-8 border-b border-gray-200">
      <div class="flex gap-3 items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor" class="w-9 h-9 text-indigo-600 bg-blue-100 rounded">
          <!-- Cercle central représentant l'identité (AfroVibe) -->
          <circle cx="32" cy="32" r="10" class="fill-current text-indigo-600" />
        
          <!-- Cercles secondaires représentant les connexions sociales -->
          <circle cx="12" cy="20" r="4" class="fill-current text-pink-500" />
          <circle cx="52" cy="20" r="4" class="fill-current text-yellow-400" />
          <circle cx="20" cy="52" r="4" class="fill-current text-green-500" />
          <circle cx="44" cy="52" r="4" class="fill-current text-blue-400" />
          <!-- Lignes pour symboliser les liens -->
          <line x1="32" y1="32" x2="12" y2="20" stroke="currentColor" stroke-width="2" />
          <line x1="32" y1="32" x2="52" y2="20" stroke="currentColor" stroke-width="2" />
          <line x1="32" y1="32" x2="20" y2="52" stroke="currentColor" stroke-width="2" />
          <line x1="32" y1="32" x2="44" y2="52" stroke="currentColor" stroke-width="2" />
        </svg>
        <p class="font-extrabold text-2xl">AFROVibe</p>
      </div>
      <div class="relative flex gap-3 items-center justify-between">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 absolute ml-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
        <input class="bg-gray-100 rounded-2xl outline-hidden h-auto py-2 px-3 pl-12 w-76 shadow-sm" type="text" placeholder="Rechercher sur Afrovibe">
        <div class="flex gap-2 items-center justify-center bg-blue-600 rounded-2xl text-white font-bold py-2 px-4">
          <div class="flex items-center justify-center text-center rounded border px-1 pb-1">
            <p class="flex items-center justify-center text-center w-2 h-3 text-sm">+</p>      
          </div>
          <p>Creer</p>
        </div>
        <div class="relative">
          <svg id="open-notifications" xmlns="http://www.w3.org/2000/svg"
              class="w-10 h-10 text-gray-500 p-[6px] bg-gray-200 rounded-full"
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
          <div class="absolute border border-gray-200 rounded bg-white px-5 py-2 shadow-lg" id="popup-notifications" style="display: none; right: 0; top: 45px; width: 390px; z-index: 100; padding-right: 40px; overflow-y: scroll;">
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
                <svg id="close-notifications" class="border border-gray-200 bg-gray-100 flex items-center justify-center rounded-full w-7 h-7 p-1 mb-2" xmlns="http://www.w3.org/2000/svg"
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
          <img class="w-9 h-9 object-cover rounded" src="assets/images/img_user.jpg" alt="">
        </div>
      </div>
    </div>
  </section>

  <section class="flex justify-center h-full">
    <!-- Partie side-bar et invitations (zone gauche) -->
    <div class="flex gap-3 flex-col my-3 w-full" style="padding: 0 40px;">

      <div class="flex gap-3 items-center justify-center bg-white px-4 py-4 rounded-2xl shadow-md w-full">
        <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user.jpg" alt="">
        <div>
          <p class="font-bold">Fayad ROUFAI</p>
          <p class="text-gray-400">@fayadroufai@gmail.com</p>
        </div>
      </div>

      <div class="flex gap-2 flex-col bg-white px-8 py-4 rounded-2xl shadow-md font-bold text-gray-400">
        <div class="flex gap-4 items-center border-b border-gray-100">
          <svg class="w-5 h-5 mb-3" viewBox="0 -0.5 25 25" fill="curentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.35 19.0001C9.35 19.4143 9.68579 19.7501 10.1 19.7501C10.5142 19.7501 10.85 19.4143 10.85 19.0001H9.35ZM10.1 16.7691L9.35055 16.7404C9.35018 16.75 9.35 16.7595 9.35 16.7691H10.1ZM12.5 14.5391L12.4736 15.2886C12.4912 15.2892 12.5088 15.2892 12.5264 15.2886L12.5 14.5391ZM14.9 16.7691H15.65C15.65 16.7595 15.6498 16.75 15.6495 16.7404L14.9 16.7691ZM14.15 19.0001C14.15 19.4143 14.4858 19.7501 14.9 19.7501C15.3142 19.7501 15.65 19.4143 15.65 19.0001H14.15ZM10.1 18.2501C9.68579 18.2501 9.35 18.5859 9.35 19.0001C9.35 19.4143 9.68579 19.7501 10.1 19.7501V18.2501ZM14.9 19.7501C15.3142 19.7501 15.65 19.4143 15.65 19.0001C15.65 18.5859 15.3142 18.2501 14.9 18.2501V19.7501ZM10.1 19.7501C10.5142 19.7501 10.85 19.4143 10.85 19.0001C10.85 18.5859 10.5142 18.2501 10.1 18.2501V19.7501ZM9.5 19.0001V18.2501C9.4912 18.2501 9.4824 18.2502 9.4736 18.2505L9.5 19.0001ZM5.9 15.6541H5.15C5.15 15.6635 5.15018 15.673 5.15054 15.6825L5.9 15.6541ZM6.65 8.94807C6.65 8.53386 6.31421 8.19807 5.9 8.19807C5.48579 8.19807 5.15 8.53386 5.15 8.94807H6.65ZM3.0788 9.95652C2.73607 10.1891 2.64682 10.6555 2.87944 10.9983C3.11207 11.341 3.57848 11.4302 3.9212 11.1976L3.0788 9.95652ZM6.3212 9.56863C6.66393 9.336 6.75318 8.86959 6.52056 8.52687C6.28793 8.18415 5.82152 8.09489 5.4788 8.32752L6.3212 9.56863ZM5.47883 8.3275C5.13609 8.5601 5.04682 9.02651 5.27942 9.36924C5.51203 9.71198 5.97844 9.80125 6.32117 9.56865L5.47883 8.3275ZM11.116 5.40807L10.7091 4.77804C10.7043 4.78114 10.6995 4.78429 10.6948 4.7875L11.116 5.40807ZM13.884 5.40807L14.3052 4.7875C14.3005 4.78429 14.2957 4.78114 14.2909 4.77804L13.884 5.40807ZM18.6788 9.56865C19.0216 9.80125 19.488 9.71198 19.7206 9.36924C19.9532 9.02651 19.8639 8.5601 19.5212 8.3275L18.6788 9.56865ZM14.9 18.2501C14.4858 18.2501 14.15 18.5859 14.15 19.0001C14.15 19.4143 14.4858 19.7501 14.9 19.7501V18.2501ZM15.5 19.0001L15.5264 18.2505C15.5176 18.2502 15.5088 18.2501 15.5 18.2501V19.0001ZM19.1 15.6541L19.8495 15.6825C19.8498 15.673 19.85 15.6635 19.85 15.6541L19.1 15.6541ZM19.85 8.94807C19.85 8.53386 19.5142 8.19807 19.1 8.19807C18.6858 8.19807 18.35 8.53386 18.35 8.94807H19.85ZM21.079 11.1967C21.4218 11.4293 21.8882 11.3399 22.1207 10.9971C22.3532 10.6543 22.2638 10.1879 21.921 9.9554L21.079 11.1967ZM19.521 8.3274C19.1782 8.09487 18.7119 8.18426 18.4793 8.52705C18.2468 8.86984 18.3362 9.33622 18.679 9.56875L19.521 8.3274ZM10.85 19.0001V16.7691H9.35V19.0001H10.85ZM10.8495 16.7977C10.8825 15.9331 11.6089 15.2581 12.4736 15.2886L12.5264 13.7895C10.8355 13.73 9.41513 15.0497 9.35055 16.7404L10.8495 16.7977ZM12.5264 15.2886C13.3911 15.2581 14.1175 15.9331 14.1505 16.7977L15.6495 16.7404C15.5849 15.0497 14.1645 13.73 12.4736 13.7895L12.5264 15.2886ZM14.15 16.7691V19.0001H15.65V16.7691H14.15ZM10.1 19.7501H14.9V18.2501H10.1V19.7501ZM10.1 18.2501H9.5V19.7501H10.1V18.2501ZM9.4736 18.2505C7.96966 18.3035 6.70648 17.1294 6.64946 15.6257L5.15054 15.6825C5.23888 18.0125 7.19612 19.8317 9.5264 19.7496L9.4736 18.2505ZM6.65 15.6541V8.94807H5.15V15.6541H6.65ZM3.9212 11.1976L6.3212 9.56863L5.4788 8.32752L3.0788 9.95652L3.9212 11.1976ZM6.32117 9.56865L11.5372 6.02865L10.6948 4.7875L5.47883 8.3275L6.32117 9.56865ZM11.5229 6.0381C12.1177 5.65397 12.8823 5.65397 13.4771 6.0381L14.2909 4.77804C13.2008 4.07399 11.7992 4.07399 10.7091 4.77804L11.5229 6.0381ZM13.4628 6.02865L18.6788 9.56865L19.5212 8.3275L14.3052 4.7875L13.4628 6.02865ZM14.9 19.7501H15.5V18.2501H14.9V19.7501ZM15.4736 19.7496C17.8039 19.8317 19.7611 18.0125 19.8495 15.6825L18.3505 15.6257C18.2935 17.1294 17.0303 18.3035 15.5264 18.2505L15.4736 19.7496ZM19.85 15.6541V8.94807H18.35V15.6541H19.85ZM21.921 9.9554L19.521 8.3274L18.679 9.56875L21.079 11.1967L21.921 9.9554Z" fill="currentColor"></path> </g></svg>
          <div class="mb-3">Acceuil</div>
        </div>
        <div class="flex gap-4 items-center border-b border-gray-100 my-1">
          <svg class="w-5 h-5 mb-3" fill="currentColor" viewBox="0 0 32 32" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Icon"> <path d="M4.96,27.999l0.051,0.001l0.043,-0.004c0.191,-0.024 0.957,-0.171 0.957,-0.996c-0,-4.971 4.029,-9 9,-9c0.661,-0 1.327,-0 1.988,-0c4.97,-0 9,4.029 9,9l-0,0c-0,0.021 0,0.041 0.002,0.061c0.015,0.325 0.153,0.537 0.323,0.676c0.178,0.164 0.415,0.263 0.675,0.263c-0,0 1,-0.057 1,-1c-0,-6.075 -4.925,-11 -11,-11c-0.661,-0 -1.327,-0 -1.988,-0c-6.075,-0 -11,4.925 -11,11c-0,-0.05 0.003,-0.092 0.008,-0.127c-0.005,0.041 -0.008,0.084 -0.008,0.127c-0,0.535 0.42,0.972 0.949,0.999Z"></path> <path d="M15.994,3.988c-2.763,-0 -5.006,2.243 -5.006,5.006c-0,2.763 2.243,5.006 5.006,5.006c2.763,0 5.006,-2.243 5.006,-5.006c0,-2.763 -2.243,-5.006 -5.006,-5.006Zm-0,2c1.659,-0 3.006,1.347 3.006,3.006c0,1.659 -1.347,3.006 -3.006,3.006c-1.659,0 -3.006,-1.347 -3.006,-3.006c-0,-1.659 1.347,-3.006 3.006,-3.006Z"></path> </g> </g></svg>
          <div class="mb-3">Profil</div>
        </div>
        <div class="flex gap-4 items-center border-b border-gray-100 my-1">
          <svg class="w-5 h-5 mb-3" fill="currentColor" viewBox="0 -6 44 44" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M42.001,32.000 L14.010,32.000 C12.908,32.000 12.010,31.104 12.010,30.001 L12.010,28.002 C12.010,27.636 12.211,27.300 12.532,27.124 L22.318,21.787 C19.040,18.242 19.004,13.227 19.004,12.995 L19.010,7.002 C19.010,6.946 19.015,6.891 19.024,6.837 C19.713,2.751 24.224,0.007 28.005,0.007 C28.006,0.007 28.008,0.007 28.009,0.007 C31.788,0.007 36.298,2.749 36.989,6.834 C36.998,6.889 37.003,6.945 37.003,7.000 L37.006,12.994 C37.006,13.225 36.970,18.240 33.693,21.785 L43.479,27.122 C43.800,27.298 44.000,27.634 44.000,28.000 L44.000,30.001 C44.000,31.104 43.103,32.000 42.001,32.000 ZM31.526,22.880 C31.233,22.720 31.039,22.425 31.008,22.093 C30.978,21.761 31.116,21.436 31.374,21.226 C34.971,18.310 35.007,13.048 35.007,12.995 L35.003,7.089 C34.441,4.089 30.883,2.005 28.005,2.005 C25.126,2.006 21.570,4.091 21.010,7.091 L21.004,12.997 C21.004,13.048 21.059,18.327 24.636,21.228 C24.895,21.438 25.033,21.763 25.002,22.095 C24.972,22.427 24.778,22.722 24.485,22.882 L14.010,28.596 L14.010,30.001 L41.999,30.001 L42.000,28.595 L31.526,22.880 ZM18.647,2.520 C17.764,2.177 16.848,1.997 15.995,1.997 C13.116,1.998 9.559,4.083 8.999,7.083 L8.993,12.989 C8.993,13.041 9.047,18.319 12.625,21.220 C12.884,21.430 13.022,21.755 12.992,22.087 C12.961,22.419 12.767,22.714 12.474,22.874 L1.999,28.588 L1.999,29.993 L8.998,29.993 C9.550,29.993 9.997,30.441 9.997,30.993 C9.997,31.545 9.550,31.993 8.998,31.993 L1.999,31.993 C0.897,31.993 -0.000,31.096 -0.000,29.993 L-0.000,27.994 C-0.000,27.629 0.200,27.292 0.521,27.117 L10.307,21.779 C7.030,18.234 6.993,13.219 6.993,12.988 L6.999,6.994 C6.999,6.939 7.004,6.883 7.013,6.829 C7.702,2.744 12.213,-0.000 15.995,-0.000 C15.999,-0.000 16.005,-0.000 16.010,-0.000 C17.101,-0.000 18.262,0.227 19.369,0.656 C19.885,0.856 20.140,1.435 19.941,1.949 C19.740,2.464 19.158,2.720 18.647,2.520 Z"></path> </g></svg>
          <div class="mb-3">Amis</div>
        </div>
        <div class="flex gap-4 items-center border-b border-gray-100 my-1">
          <svg class="w-5 h-5 mb-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17.98 10.79V14.79C17.98 15.05 17.97 15.3 17.94 15.54C17.71 18.24 16.12 19.58 13.19 19.58H12.79C12.54 19.58 12.3 19.7 12.15 19.9L10.95 21.5C10.42 22.21 9.56 22.21 9.03 21.5L7.82999 19.9C7.69999 19.73 7.41 19.58 7.19 19.58H6.79001C3.60001 19.58 2 18.79 2 14.79V10.79C2 7.86001 3.35001 6.27001 6.04001 6.04001C6.28001 6.01001 6.53001 6 6.79001 6H13.19C16.38 6 17.98 7.60001 17.98 10.79Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M21.98 6.79001V10.79C21.98 13.73 20.63 15.31 17.94 15.54C17.97 15.3 17.98 15.05 17.98 14.79V10.79C17.98 7.60001 16.38 6 13.19 6H6.79004C6.53004 6 6.28004 6.01001 6.04004 6.04001C6.27004 3.35001 7.86004 2 10.79 2H17.19C20.38 2 21.98 3.60001 21.98 6.79001Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M13.4955 13.25H13.5045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9.9955 13.25H10.0045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6.4955 13.25H6.5045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
          <div class="mb-3">Messages</div>
        </div>
        <div class="flex gap-4 items-center border-b border-gray-100 my-1">
            <svg class="w-5 h-5 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z"/>
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
          </svg>
          <div class="mb-3">Paramètres</div>
        </div>
        <div class="flex gap-4 items-center my-1">
          <svg xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-4-7 4V5z" />
          </svg>
          <div class="">Enregistrements</div>
        </div>
      </div>
      <div class="">
        <div class="flex items-center justify-between my-4">
          <p class="text-gray-400">Invitations</p>
          <p class="bg-red-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">
            4
          </p>
        </div>
        <div class="flex gap-3 flex-col bg-white px-3 py-3 rounded-2xl shadow-md">
          <div class="relative flex items-center justify-center text-center h-60 w-full rounded-2xl bg-gradient-to-br from-purple-600 to-blue-500 shadow-md">
            <img class="absolute w-12 h-12 rounded top-4 left-4 object-cover rounded border-3 border-white" src="assets/images/img_user.jpg" alt="">
            <div class="rounded-[50%] py-6 px-9 border-4 border-white bg-indigo-500 text-[28px] font-bold text-white shadow-md">R</div>
            <div class="absolute bottom-3 font-bold text-white text-lg">Mandjid BALOGOUN</div>
          </div>
          <div class="flex gap-6 items-center justify-between mt-4 font-bold">
            <p class="bg-blue-600 rounded-2xl text-white py-2 px-4 whitespace-nowrap">Accepter l'invitation</p>
            <svg class="border border-gray-200 bg-gray-100 flex items-center justify-center rounded-xl w-9 h-9 py-1 px-2" xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
                class="w-6 h-6 text-red-500 hover:text-red-600 cursor-pointer">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
        </div>
      </div>
    </div>


    <!-- Fil d'actualités (milieu) -->
    <div class="flex gap-5 flex-col my-3" style="width: 560px">
      <!-- Statut(story) des utilisateurs -->
      <div class="flex gap-4 items-center w-full overflow-x-auto scrollbar-custom" style="scroll-behavior: smooth;">
        <div class="relative flex-col items-center justify-center" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="h-full w-full object-cover rounded-2xl shadow-sm" src="assets/images/img_status.jpg" alt="">
          <div class="flex flex-col items-center justify-center absolute bottom-3 font-bold text-white ml-2">
            <div class="flex items-center justify-center rounded-xl border-4 w-9 h-9 p-1 mb-1">
              <p class="flex items-center justify-center w-full h-full text-sm text-blue-600 pb-1 rounded bg-white">+</p>      
            </div>
            <p>Ajouter storie</p>
          </div>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status_1.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status_2.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status_3.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white  shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white  shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status_4.png" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white  shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white  shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white  shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
        <div class="relative" style="flex: 0 0 auto; width: 115px; height: 210px">
          <img class="absolute w-9 h-9 rounded top-4 left-4 object-cover rounded border-3 border-white  shadow-sm" src="assets/images/img_user.jpg" alt="">
          <img class="h-full w-full object-cover rounded-2xl" src="assets/images/img_status.jpg" alt="">
          <p class="absolute bottom-3 font-bold text-white text-sm ml-2">Junior Mantinou</p>
        </div>
      </div>

      <!-- Faire une publication rapide -->
      <div class="flex items-center justify-between bg-white w-full rounded-2xl shadow-md px-4 py-3">
        <div class="flex gap-3 items-center">
          <img class="w-10 h-10 rounded object-cover" src="assets/images/img_user.jpg" alt="">
          <textarea class="w-96 flex items-center h-full outline-hidden font-bold text-gray-400 px-2" style="resize: none" name="" id="">Quoi de neuf,Fayad?</textarea>
        </div>
        <button class="flex gap-2 items-center justify-center bg-blue-600 text-white rounded-xl text-sm font-bold" style="width: 95px; padding: 10px 12px">
          <svg class="w-4 h-4 font-bold" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10.0464 14C8.54044 12.4882 8.67609 9.90087 10.3494 8.212108L15.197 3.35462C16.8703 1.67483 19.4476 1.53865 20.9536 3.05046C22.4596 4.56228 22.3239 7.14956 20.6506 8.82935L18.2268 11.2626" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></path> <path d="M13.9536 10C15.4596 11.5118 15.3239 14.0991 13.6506 15.7789L11.2268 18.2121L8.80299 20.6454C7.12969 22.3252 4.55237 22.4613 3.0464 20.9495C1.54043 19.4377 1.67609 16.8504 3.34939 15.1706L5.77323 12.7373" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
          Publier
        </button>
      </div>

      <!-- Publications et Posts des utilisateurs -->
      <div class="flex flex-col justify-center bg-white rounded-2xl shadow-md px-5 py-4">
        <div class="flex items-center justify-between">
          <div class="flex gap-3 items-center justify-center">
            <img class="w-10 h-10 rounded object-cover" src="assets/images/img_user_publicaton.jpg" alt="">
            <div>
              <p class="font-bold">Raphael RAOUFOU</p>
              <p class="text-gray-400">il y'a 10h</p>
            </div>
          </div>
          <div class="flex items-center justify-center rounded border px-4 text-gray-400 w-5 h-5" style="padding-bottom: 21px;">
            <p class="flex items-center justify-center w-2 h-3 text-3xl">...</p>      
          </div>
        </div>
        <div class="my-4">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde non repellendus eum cumque adipisci! Suscipit deleniti ea dolorum dolor totam expedita! Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus necessitatibus facilis veniam exercitationem, consectetur explicabo? Dignissimos architecto impedit rem corrupti culpa, fugit enim molestiae sed.
        </div>
        <img class="h-96 w-full rounded-xl object-cover" src="assets/images/img_publication.jpg" alt="">
        <div class="flex items-center justify-between my-4">
          <div class="flex gap-5 items-center justify-between">
            <div class="flex items-center justify-center" style="margin-left: 10px; gap: 4px">
              <!-- Like (non activé) -->
              <!-- <svg xmlns="http://www.w3.org/2000/svg"
                  class="w-7 h-7 text-gray-400"
                  fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                        4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                        4.5 0 00-6.364 0z" />
              </svg> -->
              <!-- Like (activé) -->
              <svg xmlns="http://www.w3.org/2000/svg"
                  class="w-7 h-7 text-red-500 cursor-pointer"
                  fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 
                        2 12.28 2 8.5 2 5.42 4.42 3 
                        7.5 3c1.74 0 3.41 0.81 4.5 
                        2.09C13.09 3.81 14.76 3 
                        16.5 3 19.58 3 22 5.42 22 
                        8.5c0 3.78-3.4 6.86-8.55 
                        11.54L12 21.35z" />
              </svg>
              <p>1.8k</p>
            </div>
            <div class="flex items-center justify-center" style="gap: 4px">
              <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-6 h-6 text-gray-500 hover:text-blue-500 cursor-pointer transition duration-200">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 12c0 4.97-4.03 9-9 9a8.96 8.96 0 01-4.479-1.175L3 21l1.175-4.479A8.96 8.96 0 013 12c0-4.97 4.03-9 9-9s9 4.03 9 9z" />
              </svg>
              <p>2.5k</p>
            </div>
            <div class="flex items-center justify-center">
              <svg class="w-9 h-9 text-gray-400" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.734 15.8974L19.22 12.1374C19.3971 11.9927 19.4998 11.7761 19.4998 11.5474C19.4998 11.3187 19.3971 11.1022 19.22 10.9574L14.734 7.19743C14.4947 6.9929 14.1598 6.94275 13.8711 7.06826C13.5824 7.19377 13.3906 7.47295 13.377 7.78743V9.27043C7.079 8.17943 5.5 13.8154 5.5 16.9974C6.961 14.5734 10.747 10.1794 13.377 13.8154V15.3024C13.3888 15.6178 13.5799 15.8987 13.8689 16.0254C14.158 16.1521 14.494 16.1024 14.734 15.8974Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
              <p>145</p>
            </div>
          </div>
          <div class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-4-7 4V5z" />
            </svg>
          </div>
        </div>
        <div class="flex items-center justify-between mb-4 mt-5 border-t border-gray-300">
          <div class="flex gap-2 justify-center">
            <img class="w-12 h-12 rounded-xl object-cover" src="assets/images/img_user_publicaton.jpg" alt="">
            <textarea class="bg-gray-200 rounded-xl w-96 outline-hidden" style="resize: none; height: 74px; padding: 6px 12px;" name="" id="">Commenter en tant que Raphael RAOUFOU</textarea>
          </div>
          <div class="flex justify-center items-center rounded-full bg-gray-400 p-2">
            <svg  class="w-6 h-6 text-gray-400 hover:text-green-500 cursor-pointer transition-colors duration-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.7639 12H10.0556M3 8.00003H5.5M4 12H5.5M4.5 16H5.5M9.96153 12.4896L9.07002 15.4486C8.73252 16.5688 8.56376 17.1289 8.70734 17.4633C8.83199 17.7537 9.08656 17.9681 9.39391 18.0415C9.74792 18.1261 10.2711 17.8645 11.3175 17.3413L19.1378 13.4311C20.059 12.9705 20.5197 12.7402 20.6675 12.4285C20.7961 12.1573 20.7961 11.8427 20.6675 11.5715C20.5197 11.2598 20.059 11.0295 19.1378 10.5689L11.3068 6.65342C10.2633 6.13168 9.74156 5.87081 9.38789 5.95502C9.0808 6.02815 8.82627 6.24198 8.70128 6.53184C8.55731 6.86569 8.72427 7.42461 9.05819 8.54246L9.96261 11.5701C10.0137 11.7411 10.0392 11.8266 10.0493 11.9137C10.0583 11.991 10.0582 12.069 10.049 12.1463C10.0387 12.2334 10.013 12.3188 9.96153 12.4896Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Partie invitations, suggestions, contacts (Zone droite) -->
    <div class="flex gap-6 flex-col my-3 w-full" style="padding: 0 40px;">
      <!-- Partie Invitations recues -->
      <div class="flex flex-col justify-center">
        <div class="flex items-center justify-between mb-1">
          <div class="text-gray-400 font-bold">INVITATIONS RECUES</div>
          <div class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">5</div>
        </div>
        <div class="flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-2 px-3 mb-4 text-sm">
          <div class="flex gap-3 justify-center">
            <div class="flex gap-3 items-center justify-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <div class="break-words w-48"><strong>ULRICH MORGAN</strong> veut faire partie de vos amis</div>
            </div>
            <div class="text-gray-600 text-sm font-bold">1h</div>
          </div>
          <div class="flex gap-6 items-center justify-center">
            <button class="flex items-center justify-center bg-blue-600 text-white rounded-xl px-5 py-2 text-sm" style="width: 105px;">Accepter</button>
            <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm" style="width: 105px;">Refuser</button>
          </div>
        </div>
        <div class="flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-2 px-3 mb-4 text-sm">
          <div class="flex gap-3 justify-center">
            <div class="flex gap-3 items-center justify-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <div class="break-words w-48"><strong>Joseph ADECHINAN</strong> veut faire partie de vos amis</div>
            </div>
            <div class="text-gray-600 text-sm font-bold">8sem</div>
          </div>
          <div class="flex gap-6 items-center justify-center">
            <button class="flex items-center justify-center bg-blue-600 text-white rounded-xl px-5 py-2 text-sm" style="width: 105px;">Accepter</button>
            <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm" style="width: 105px;">Refuser</button>
          </div>
        </div>
        <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm bg-gray-100 text-blue-600 shadow-sm">Voir tout</button>
      </div>
      
      <!-- Partie Invitations envoyées -->
      <div class="flex flex-col justify-center">
        <div class="flex items-center justify-between mb-1">
          <div class="text-gray-400 font-bold">INVITATIONS ENVOYEES</div>
          <div class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">5</div>
        </div>
        <div class="flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-2 px-3 mb-4 text-sm">
          <div class="flex gap-3 justify-center">
            <div class="flex gap-3 items-center justify-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <div class="break-words w-44">Invitation envoyée à <strong>Jojo ALAO</strong></div>
            </div>
            <div class="text-gray-600 text-sm font-bold">2ans</div>
          </div>
          <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm w-full text-red-500 shadow-sm">Annuler</button>
        </div>
        <div class="flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-2 px-3 mb-4 text-sm">
          <div class="flex gap-3 justify-center">
            <div class="flex gap-3 items-center justify-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <div class="break-words w-44">Invitation envoyée à <strong>Abdel CHEIKH</strong></div>
            </div>
            <div class="text-gray-600 text-sm font-bold">2m</div>
          </div>
          <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm w-full text-red-500 shadow-sm">Annuler</button>
        </div>
        <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm bg-gray-100 text-blue-600 shadow-sm">Voir tout</button>
      </div>

      <!-- Partie Suggestions d'amis -->
      <div class="flex flex-col justify-center">
        <div class="text-gray-400 mb-1 font-bold">SUGGESTION D'AMIS</div>
        <div class="flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-3 px-2 mb-4 text-sm">
          <div class="flex items-center gap-3 justify-center">
            <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
            <div class="flex gap-3 flex-col justify-center">
              <strong>Georges SANNI</strong>
              <div class="flex gap-2 items-center justify-center">
                <button class="flex items-center justify-center bg-blue-600 text-white rounded-xl px-5 py-2 text-sm whitespace-nowrap" style="width: 90px;">Ajouter ami</button>
                <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-indigo-300 text-sm" style="width: 90px;">Retirer</button>
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-3 px-2 mb-4 text-sm">
          <div class="flex gap-3 items-center justify-center">
            <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
            <div class="flex gap-3 flex-col justify-center">
              <strong>Gabriel BAKARY</strong>
              <div class="flex gap-2 items-center justify-center">
                <button class="flex items-center justify-center bg-blue-600 text-white rounded-xl px-5 py-2 text-sm whitespace-nowrap" style="width: 90px;">Ajouter ami</button>
                <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-indigo-300 text-sm" style="width: 90px;">Retirer</button>
              </div>
            </div>
          </div>
        </div>
        <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm bg-gray-100 text-blue-600 shadow-sm">Voir plus</button>
      </div>

      <!-- Amis en connectés -->
      <div>
        <div class="flex items-center justify-between mb-1">
          <div class="text-gray-400 font-bold">CONTACTS EN LIGNE</div>
          <div class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">15</div>
        </div>
        <div class="flex gap-5 flex-col gap-4 justify-center bg-white rounded-2xl shadow-md py-5 px-6 mb-4">
          <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <strong>Jojo ALAO</strong>
            </div>
            <div class="bg-green-500 rounded-full h-2 w-2"></div>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <strong>Jojo ALAO</strong>
            </div>
            <div class="bg-green-500 rounded-full h-2 w-2"></div>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <strong>Jojo ALAO</strong>
            </div>
            <div class="bg-green-500 rounded-full h-2 w-2"></div>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <strong>Jojo ALAO</strong>
            </div>
            <div class="bg-green-500 rounded-full h-2 w-2"></div>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
              <img class="w-10 h-10 object-cover rounded" src="assets/images/img_user_publicaton.jpg" alt="">
              <strong>Jojo ALAO</strong>
            </div>
            <div class="bg-green-500 rounded-full h-2 w-2"></div>
          </div>
        </div>
      </div>
    </div>
  </section>




  <script src="assets/js/index.js"></script>
</body>
</html>