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
  
    <div class="flex mb-9 justify-center items-center">
        <!-- Logo -->
        <div href="/socialnetwork/home.php" class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-xl">A</span>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Afrovibe</h1>
        </div>
    </div>

    <form class="flex flex-col gap-4 w-[95%] md:w-full max-w-sm bg-white p-6 rounded-lg shadow">
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