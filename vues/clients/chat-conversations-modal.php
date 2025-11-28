<?php 


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<!-- <section id="popup-messages" class="absolute hidden justify-center items-center z-[200]">
    <div class="flex gap-1 flex-col bg-white shadow-lg rounded-2xl px-6 py-5" style="width: 35vw; height:520px; margin: 35px 420px"> -->

   <section id="popup-messages" class="absolute hidden justify-center items-center z-[200] inset-0 bg-black/30 top-0 left-0 w-screen h-screen">
    <div class="flex flex-col gap-1 bg-white shadow-lg rounded-2xl 
               w-[90%] lg:w-[35%] max-w-[600px] h-[520px] p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="text-blue-600 font-bold text-2xl">Messages</div>
            <svg id="close-messages" class="border border-gray-200 bg-gray-100 hover:bg-gray-50 flex items-center justify-center rounded-full w-6 h-6 p-1 mb-2 cursor-pointer" xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                    >
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-6 h-6 text-gray-500 ml-4 top-2 opacity-300 z-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input class="searchBar relative bg-gray-100 rounded-2xl h-auto py-2 px-3 pl-12 w-80 border border-gray-300 rounded-lg outline-none transition-opacity duration-300 opacity-70 focus:opacity-100 focus:ring-2 focus:ring-blue-500" type="text" placeholder="Rechercher...">

            <!-- Loader caché par défaut -->
            <div id="loader" class="absolute right-23 top-1/2 -translate-y-1/2 hidden">
                <div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
        <div class="users-list flex gap-1 flex-col my-6 overflow-y-auto  transition-opacity duration-300 opacity-100">
           <!-- Ouverture modal de conversations utilisateurs -->
        </div>
    </div>
   </section>



   <script src="../../assets/js/chat-conversations-modal.js"></script>
</body>
</html>