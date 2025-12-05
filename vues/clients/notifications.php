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

    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="flex items-center gap-4 p-4">
            <!-- Bouton retour -->
            <button onclick="window.history.back()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900">Notifications</h1>
                <p id="notif-count" class="text-sm text-gray-500">Chargement...</p>
            </div>
            
            <!-- Actions -->
            <!-- <button onclick="" class="text-sm text-blue-600 font-medium hover:text-blue-700 transition-colors">
                Tout marquer comme lu
            </button> -->
        </div>
    </header>

    <main class="pb-20">
        <div id="notifications-container" class="bg-white">
            <!-- Les notifications sont ajoutées ici -->
        </div>

        <!-- Message vide -->
        <div id="empty-notifications" class="hidden">
            <div class="flex flex-col items-center justify-center py-20 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Aucune notification</h2>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="flex justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>
    </main>


    <!-- Navigation bottom mobile -->
    <?php require '../../inclusions/components/mobileNavigation.php' ?>

   


    <script src="../../assets/js/mobileNotification.js"></script>
</body>
</html>