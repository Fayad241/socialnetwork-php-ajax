<?php 
  require __DIR__ . '/../../inclusions/database.php';

  $current_user = $_SESSION['user_id'];

  if (!isset($current_user)) {
    header("Location: ../../vues/clients/login.php"); 
  }

  // Requete pour afficher les informations personnelles de l'utilisateur
  $stmt = $pdo->prepare("SELECT * FROM users WHERE `unique-id` = :user_id");
  $stmt->execute([':user_id' => $current_user]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

      <div class="flex gap-4 items-center justify-center bg-white px-2 py-4 rounded-2xl shadow-md w-full">
        <img class="w-12 h-12 object-cover rounded" src="/socialnetwork/profile-pic/<?=$user['profile-pic']?>" alt="">
        <div>
          <p class="font-bold"> <?= htmlspecialchars($user['last-name'] . ' ' . $user['first-name']); ?> </p>
          <p class="text-gray-400"><?= htmlspecialchars($user['email']) ?></p>
        </div>
      </div>

      <div class="flex gap-3 flex-col bg-white px-8 py-4 rounded-2xl shadow-md font-bold text-gray-500">

        <div class="menu-item active">
            <div class="flex gap-4 items-center border-b border-gray-100">
                <svg class="w-5 h-5 mb-3" viewBox="0 -0.5 25 25" fill="curentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.35 19.0001C9.35 19.4143 9.68579 19.7501 10.1 19.7501C10.5142 19.7501 10.85 19.4143 10.85 19.0001H9.35ZM10.1 16.7691L9.35055 16.7404C9.35018 16.75 9.35 16.7595 9.35 16.7691H10.1ZM12.5 14.5391L12.4736 15.2886C12.4912 15.2892 12.5088 15.2892 12.5264 15.2886L12.5 14.5391ZM14.9 16.7691H15.65C15.65 16.7595 15.6498 16.75 15.6495 16.7404L14.9 16.7691ZM14.15 19.0001C14.15 19.4143 14.4858 19.7501 14.9 19.7501C15.3142 19.7501 15.65 19.4143 15.65 19.0001H14.15ZM10.1 18.2501C9.68579 18.2501 9.35 18.5859 9.35 19.0001C9.35 19.4143 9.68579 19.7501 10.1 19.7501V18.2501ZM14.9 19.7501C15.3142 19.7501 15.65 19.4143 15.65 19.0001C15.65 18.5859 15.3142 18.2501 14.9 18.2501V19.7501ZM10.1 19.7501C10.5142 19.7501 10.85 19.4143 10.85 19.0001C10.85 18.5859 10.5142 18.2501 10.1 18.2501V19.7501ZM9.5 19.0001V18.2501C9.4912 18.2501 9.4824 18.2502 9.4736 18.2505L9.5 19.0001ZM5.9 15.6541H5.15C5.15 15.6635 5.15018 15.673 5.15054 15.6825L5.9 15.6541ZM6.65 8.94807C6.65 8.53386 6.31421 8.19807 5.9 8.19807C5.48579 8.19807 5.15 8.53386 5.15 8.94807H6.65ZM3.0788 9.95652C2.73607 10.1891 2.64682 10.6555 2.87944 10.9983C3.11207 11.341 3.57848 11.4302 3.9212 11.1976L3.0788 9.95652ZM6.3212 9.56863C6.66393 9.336 6.75318 8.86959 6.52056 8.52687C6.28793 8.18415 5.82152 8.09489 5.4788 8.32752L6.3212 9.56863ZM5.47883 8.3275C5.13609 8.5601 5.04682 9.02651 5.27942 9.36924C5.51203 9.71198 5.97844 9.80125 6.32117 9.56865L5.47883 8.3275ZM11.116 5.40807L10.7091 4.77804C10.7043 4.78114 10.6995 4.78429 10.6948 4.7875L11.116 5.40807ZM13.884 5.40807L14.3052 4.7875C14.3005 4.78429 14.2957 4.78114 14.2909 4.77804L13.884 5.40807ZM18.6788 9.56865C19.0216 9.80125 19.488 9.71198 19.7206 9.36924C19.9532 9.02651 19.8639 8.5601 19.5212 8.3275L18.6788 9.56865ZM14.9 18.2501C14.4858 18.2501 14.15 18.5859 14.15 19.0001C14.15 19.4143 14.4858 19.7501 14.9 19.7501V18.2501ZM15.5 19.0001L15.5264 18.2505C15.5176 18.2502 15.5088 18.2501 15.5 18.2501V19.0001ZM19.1 15.6541L19.8495 15.6825C19.8498 15.673 19.85 15.6635 19.85 15.6541L19.1 15.6541ZM19.85 8.94807C19.85 8.53386 19.5142 8.19807 19.1 8.19807C18.6858 8.19807 18.35 8.53386 18.35 8.94807H19.85ZM21.079 11.1967C21.4218 11.4293 21.8882 11.3399 22.1207 10.9971C22.3532 10.6543 22.2638 10.1879 21.921 9.9554L21.079 11.1967ZM19.521 8.3274C19.1782 8.09487 18.7119 8.18426 18.4793 8.52705C18.2468 8.86984 18.3362 9.33622 18.679 9.56875L19.521 8.3274ZM10.85 19.0001V16.7691H9.35V19.0001H10.85ZM10.8495 16.7977C10.8825 15.9331 11.6089 15.2581 12.4736 15.2886L12.5264 13.7895C10.8355 13.73 9.41513 15.0497 9.35055 16.7404L10.8495 16.7977ZM12.5264 15.2886C13.3911 15.2581 14.1175 15.9331 14.1505 16.7977L15.6495 16.7404C15.5849 15.0497 14.1645 13.73 12.4736 13.7895L12.5264 15.2886ZM14.15 16.7691V19.0001H15.65V16.7691H14.15ZM10.1 19.7501H14.9V18.2501H10.1V19.7501ZM10.1 18.2501H9.5V19.7501H10.1V18.2501ZM9.4736 18.2505C7.96966 18.3035 6.70648 17.1294 6.64946 15.6257L5.15054 15.6825C5.23888 18.0125 7.19612 19.8317 9.5264 19.7496L9.4736 18.2505ZM6.65 15.6541V8.94807H5.15V15.6541H6.65ZM3.9212 11.1976L6.3212 9.56863L5.4788 8.32752L3.0788 9.95652L3.9212 11.1976ZM6.32117 9.56865L11.5372 6.02865L10.6948 4.7875L5.47883 8.3275L6.32117 9.56865ZM11.5229 6.0381C12.1177 5.65397 12.8823 5.65397 13.4771 6.0381L14.2909 4.77804C13.2008 4.07399 11.7992 4.07399 10.7091 4.77804L11.5229 6.0381ZM13.4628 6.02865L18.6788 9.56865L19.5212 8.3275L14.3052 4.7875L13.4628 6.02865ZM14.9 19.7501H15.5V18.2501H14.9V19.7501ZM15.4736 19.7496C17.8039 19.8317 19.7611 18.0125 19.8495 15.6825L18.3505 15.6257C18.2935 17.1294 17.0303 18.3035 15.5264 18.2505L15.4736 19.7496ZM19.85 15.6541V8.94807H18.35V15.6541H19.85ZM21.921 9.9554L19.521 8.3274L18.679 9.56875L21.079 11.1967L21.921 9.9554Z" fill="currentColor"></path> </g></svg>
                <div class="mb-3">Acceuil</div>
              </div>
        </div>

        <div class="menu-item">
            <div class="flex gap-4 items-center border-b border-gray-100 my-1">
                <svg class="w-5 h-5 mb-3" fill="currentColor" viewBox="0 0 32 32" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Icon"> <path d="M4.96,27.999l0.051,0.001l0.043,-0.004c0.191,-0.024 0.957,-0.171 0.957,-0.996c-0,-4.971 4.029,-9 9,-9c0.661,-0 1.327,-0 1.988,-0c4.97,-0 9,4.029 9,9l-0,0c-0,0.021 0,0.041 0.002,0.061c0.015,0.325 0.153,0.537 0.323,0.676c0.178,0.164 0.415,0.263 0.675,0.263c-0,0 1,-0.057 1,-1c-0,-6.075 -4.925,-11 -11,-11c-0.661,-0 -1.327,-0 -1.988,-0c-6.075,-0 -11,4.925 -11,11c-0,-0.05 0.003,-0.092 0.008,-0.127c-0.005,0.041 -0.008,0.084 -0.008,0.127c-0,0.535 0.42,0.972 0.949,0.999Z"></path> <path d="M15.994,3.988c-2.763,-0 -5.006,2.243 -5.006,5.006c-0,2.763 2.243,5.006 5.006,5.006c2.763,0 5.006,-2.243 5.006,-5.006c0,-2.763 -2.243,-5.006 -5.006,-5.006Zm-0,2c1.659,-0 3.006,1.347 3.006,3.006c0,1.659 -1.347,3.006 -3.006,3.006c-1.659,0 -3.006,-1.347 -3.006,-3.006c-0,-1.659 1.347,-3.006 3.006,-3.006Z"></path> </g> </g></svg>
              <div class="mb-3">Profil</div>
            </div>
        </div>

        <div class="menu-item">
            <div class="flex gap-4 items-center border-b border-gray-100 my-1">
                <svg class="w-5 h-5 mb-3" fill="currentColor" viewBox="0 -6 44 44" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M42.001,32.000 L14.010,32.000 C12.908,32.000 12.010,31.104 12.010,30.001 L12.010,28.002 C12.010,27.636 12.211,27.300 12.532,27.124 L22.318,21.787 C19.040,18.242 19.004,13.227 19.004,12.995 L19.010,7.002 C19.010,6.946 19.015,6.891 19.024,6.837 C19.713,2.751 24.224,0.007 28.005,0.007 C28.006,0.007 28.008,0.007 28.009,0.007 C31.788,0.007 36.298,2.749 36.989,6.834 C36.998,6.889 37.003,6.945 37.003,7.000 L37.006,12.994 C37.006,13.225 36.970,18.240 33.693,21.785 L43.479,27.122 C43.800,27.298 44.000,27.634 44.000,28.000 L44.000,30.001 C44.000,31.104 43.103,32.000 42.001,32.000 ZM31.526,22.880 C31.233,22.720 31.039,22.425 31.008,22.093 C30.978,21.761 31.116,21.436 31.374,21.226 C34.971,18.310 35.007,13.048 35.007,12.995 L35.003,7.089 C34.441,4.089 30.883,2.005 28.005,2.005 C25.126,2.006 21.570,4.091 21.010,7.091 L21.004,12.997 C21.004,13.048 21.059,18.327 24.636,21.228 C24.895,21.438 25.033,21.763 25.002,22.095 C24.972,22.427 24.778,22.722 24.485,22.882 L14.010,28.596 L14.010,30.001 L41.999,30.001 L42.000,28.595 L31.526,22.880 ZM18.647,2.520 C17.764,2.177 16.848,1.997 15.995,1.997 C13.116,1.998 9.559,4.083 8.999,7.083 L8.993,12.989 C8.993,13.041 9.047,18.319 12.625,21.220 C12.884,21.430 13.022,21.755 12.992,22.087 C12.961,22.419 12.767,22.714 12.474,22.874 L1.999,28.588 L1.999,29.993 L8.998,29.993 C9.550,29.993 9.997,30.441 9.997,30.993 C9.997,31.545 9.550,31.993 8.998,31.993 L1.999,31.993 C0.897,31.993 -0.000,31.096 -0.000,29.993 L-0.000,27.994 C-0.000,27.629 0.200,27.292 0.521,27.117 L10.307,21.779 C7.030,18.234 6.993,13.219 6.993,12.988 L6.999,6.994 C6.999,6.939 7.004,6.883 7.013,6.829 C7.702,2.744 12.213,-0.000 15.995,-0.000 C15.999,-0.000 16.005,-0.000 16.010,-0.000 C17.101,-0.000 18.262,0.227 19.369,0.656 C19.885,0.856 20.140,1.435 19.941,1.949 C19.740,2.464 19.158,2.720 18.647,2.520 Z"></path> </g></svg>
              <div class="mb-3">Amis</div>
            </div>
        </div>

        <div class="menu-item" id="open-messages">
            <div class="flex gap-4 items-center border-b border-gray-100 my-1 cursor-pointer">
                <svg class="w-5 h-5 mb-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17.98 10.79V14.79C17.98 15.05 17.97 15.3 17.94 15.54C17.71 18.24 16.12 19.58 13.19 19.58H12.79C12.54 19.58 12.3 19.7 12.15 19.9L10.95 21.5C10.42 22.21 9.56 22.21 9.03 21.5L7.82999 19.9C7.69999 19.73 7.41 19.58 7.19 19.58H6.79001C3.60001 19.58 2 18.79 2 14.79V10.79C2 7.86001 3.35001 6.27001 6.04001 6.04001C6.28001 6.01001 6.53001 6 6.79001 6H13.19C16.38 6 17.98 7.60001 17.98 10.79Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M21.98 6.79001V10.79C21.98 13.73 20.63 15.31 17.94 15.54C17.97 15.3 17.98 15.05 17.98 14.79V10.79C17.98 7.60001 16.38 6 13.19 6H6.79004C6.53004 6 6.28004 6.01001 6.04004 6.04001C6.27004 3.35001 7.86004 2 10.79 2H17.19C20.38 2 21.98 3.60001 21.98 6.79001Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M13.4955 13.25H13.5045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9.9955 13.25H10.0045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6.4955 13.25H6.5045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                <div class="mb-3">Messages</div>
            </div>
        </div>

        <a href="vues/clients/posts-saved.php?user_id=<?= $_SESSION['user_id'] ?>" class="menu-item">
          <div class="flex gap-4 items-center my-1">
          <svg xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-4-7 4V5z" />
          </svg>
            <div class="">Enregistrements</div>
          </div>
        </a>

      </div>


      <button id="settings-btn"
        class="flex items-center justify-center gap-2 rounded-2xl mt-2 px-6 py-3 font-semibold text-gray-800 bg-white rounded-bl-2xl border border-gray-200 hover:shadow-md hover:bg-gray-50 transform hover:-translate-y-0.5 transition-all duration-300 ease-out cursor-pointer outline-none">
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z"/>
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
        </svg>
        Paramètres
      </button>
     
      <button
        id="logoutBtn"
        type="button"
        class="flex items-center justify-center gap-2 rounded-2xl px-6 py-3 font-semibold text-white bg-gradient-to-r from-red-500 to-red-400 rounded-bl-2xl shadow-sm hover:shadow-md hover:from-red-400 hover:to-red-500 transform hover:-translate-y-0.5 transition-all duration-300 ease-out cursor-pointer outline-none"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
        </svg>
        Se déconnecter
      </button>

</body>
</html>