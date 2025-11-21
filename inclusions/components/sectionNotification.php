<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div class="relative">
        <svg id="open-notifications" xmlns="http://www.w3.org/2000/svg"
            class="w-10 h-10 bg-blue-100 text-blue-500 p-[6px] rounded-full cursor-pointer"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67
                6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595
                1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="notif-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-4 h-4 flex items-center justify-center rounded-full hidden">0</span>


        <!-- UI Affichage Notifications -->
        <div class="absolute border border-gray-200 rounded-2xl bg-white shadow-2xl overflow-hidden hidden right-0 top-12 w-[390px] h-[80vh] transition-transform duration-300 transform -translate-y-5 opacity-0" id="popup-notifications">
            <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 bg-gradient-to-r from-indigo-50 to-blue-50">
                    <div class="flex gap-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 p-1 rounded-full bg-indigo-100 text-blue-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                                6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67
                                6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595
                                1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <p class="font-bold text-xl text-gray-800">Notifications</p>
                        <span id="notif-badge" class="notif-badge bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5 hidden">0</span>
                    </div>
                    <button id="close-notifications" class="border border-gray-300 bg-white hover:bg-gray-50 flex items-center justify-center rounded-full w-8 h-8 p-1 cursor-pointer transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="w-5 h-5 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Notifications List -->
                <div class="notifications-container overflow-y-auto flex-1 py-3" id="notifications-container">
                    <!-- Les notifications seront ajoutées ici -->
                </div>

                <!-- Message vide (caché par défaut) -->
                <div id="empty-notifications" class="text-center py-12 hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-gray-500 font-medium">Aucune notification</p>
                    <!-- <p class="text-gray-400 text-sm mt-1">Vous êtes à jour !</p> -->
                </div>
            </div>
        </div>

          
        </div>

    



    <script src="assets/js/notification.js"></script>
</body>
</html>