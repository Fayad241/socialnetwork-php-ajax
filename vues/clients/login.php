<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="../../assets/css/output.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen">
  
    <div class="flex gap-[1px] mb-5 justify-center items-center">
        <svg width="44" height="44" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="blueGradient" x1="0" y1="0" x2="1" y2="0">
              <stop offset="0%" stop-color="#2563EB" />   <!-- blue-600 -->
              <stop offset="50%" stop-color="#3B82F6" />  <!-- blue-500 -->
              <stop offset="100%" stop-color="#06B6D4" /> <!-- cyan-400 -->
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
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-400 to-cyan-400">
        AFRO<span class="font-light">vibe</span>
        </h1>
    </div>

    <form class="flex flex-col gap-4 w-full max-w-sm bg-white p-6 rounded-lg shadow">
        <div class="mb-3 font-bold text-4xl text-gray-800 text-left mright-auto">Connexion</div>
        <!-- Email -->
        <div class="w-full flex flex-col gap-2">
            <label for="email" class="text-blue-400 font-semibold">Email</label>
            <input
            type="email"
            name="email"
            id="email"
            class="w-full px-3 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            required
            />
        </div>

        <!-- Password -->
        <div class="w-full flex flex-col gap-2">
            <label for="password" class="text-blue-400 font-semibold">Password</label>
            <input
            type="password"
            name="password"
            id="password"
            class="w-full px-3 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-400 transition"
            required
            />
        </div>

        <!-- Lien mot de passe oublié -->
        <div class="w-full text-sm text-left">
            <a href="#" class="text-blue-500 hover:underline">Mot de passe oublié?</a>
        </div>

        <!-- Bouton de connexion -->
        <input
            type="submit"
            value="Se connecter"
            class="w-full py-3 rounded-full bg-gray-700 text-white font-semibold text-sm outline-0 cursor-pointer hover:bg-blue-600 hover:text-gray-100 transition"
        />

        <!-- Lien inscription -->
        <div class="text-sm text-center text-gray-700">
            Nouveau membre?
            <a href="#" class="text-blue-500 hover:underline">Inscrivez vous ici</a>
        </div>
    </form>





    <script src="../../assets/js/login.js"></script>
</body>
</html>