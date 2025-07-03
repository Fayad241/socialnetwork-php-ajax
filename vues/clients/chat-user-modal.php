<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Document</title>
</head>
<body style="overflow: hidden">

   <section class="absolute flex justify-center items-center" style="z-index: 200">
    <div class="flex gap-1 flex-col bg-white shadow-lg rounded-2xl px-6 py-5" style="width: 45vw; height:520px; margin: 30px 340px">
        <div class="flex items-center justify-between mb-4">
            <div class="text-blue-600 font-bold text-2xl">Messages</div>
            <svg class="border border-gray-200 bg-gray-100 flex items-center justify-center rounded-full w-7 h-7 p-1 mb-2" xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                    class="w-6 h-6 text-red-500 hover:text-red-600 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-6 h-6 text-gray-500 ml-4 top-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input class="bg-gray-100 rounded-2xl outline-hidden h-auto py-2 px-3 pl-12 w-80 shadow-lg" type="text" placeholder="Rechercher...">
        </div>
        <div class="flex gap-1 flex-col my-6">
            <div class="flex justify-between my-4">
                <div class="flex gap-4">
                    <div class="relative">
                      <img class="w-13 h-13 rounded object-cover" src="assets/images/img_user_publicaton.jpg" alt="">
                      <div class="absolute w-3 h-3 bg-green-500 rounded-full border-2 border-white" style="right: -5px; bottom:15px"></div>
                    </div>
                    <div style="width: 380px">
                        <strong>Junior Rice</strong>
                        <p class="text-gray-600">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Praesentium omnis voluptatem quam ipsum!</p>
                    </div>
                </div>
                <div class="flex gap-2 flex-col items-center">
                    <p class="text-gray-600">12:35</p>
                    <p class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">2</p>
                </div>
            </div>
            <div class="flex justify-between my-4">
                <div class="flex gap-4">
                    <div class="relative">
                      <img class="w-13 h-13 rounded object-cover" src="assets/images/img_user_publicaton.jpg" alt="">
                      <div class="absolute w-3 h-3 bg-gray-400 rounded-full border-2 border-white" style="right: -5px; bottom:15px"></div>
                    </div>
                    <div style="width: 380px">
                        <strong>Junior Rice</strong>
                        <p class="text-gray-600">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Praesentium omnis voluptatem quam ipsum!</p>
                    </div>
                </div>
                <div class="flex gap-2 flex-col items-center">
                    <p class="text-gray-600">12:35</p>
                    <p class="bg-blue-500 text-white text-xs font-bold flex items-center justify-center rounded-full" style="padding: 2px 6px">2</p>
                </div>
            </div>
        </div>
    </div>
   </section>
</body>
</html>