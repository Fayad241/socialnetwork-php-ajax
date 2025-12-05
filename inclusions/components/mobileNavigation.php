<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="flex lg:hidden bg-white border-t border-gray-200 p-2 sticky bottom-0 z-50">
        <div class="flex justify-between gap-8 items-center">
            <a href="/socialnetwork/home.php" class="flex flex-col items-center gap-1 p-2 text-blue-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="text-[10px] font-medium">Accueil</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 p-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                </svg>
                <span class="text-[10px] font-medium">Amis</span>
            </a>
            <a href="/socialnetwork/vues/clients/posts.php" class="flex flex-col items-center -mt-5">
                <div class="bg-gradient-to-r from-cyan-400 to-purple-600 rounded-full p-3 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </a>
            <a href="#" onclick="openMobileConversations()" class="flex flex-col items-center gap-1 p-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                </svg>
                <span class="text-[10px] font-medium">Messages</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 p-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </div>
    </nav>
</body>
</html>