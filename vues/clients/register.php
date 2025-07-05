<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/output.css" rel="stylesheet">
    <!-- <link href="../../assets/css/register.css" rel="stylesheet"> -->
    <title>Document</title>
</head>
<body class="bg-gray-50">
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg">
    <!-- Logo et nom de l'application -->
    <div class="text-center mb-6">
      <img src="logo.png" alt="Logo" class="w-16 h-16 mx-auto">
      <h1 class="text-2xl font-bold mt-2 text-gray-800">SocialApp</h1>
    </div>

    <!-- Formulaire multi-étapes -->
    <form id="multiStepForm">
      <!-- Étape 1: Informations personnelles -->
      <div class="step" data-step="1">
        <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
        name="nom" placeholder="Nom" class="mb-4" required>
        <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
        name="prenom" placeholder="Prénom" class="mb-4" required>
        <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
        name="email" type="email" placeholder="Email" class="mb-4" required>
        <textarea class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
        name="bio" placeholder="Bio" class="mb-4 h-24" required></textarea>
        <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
        name="password" type="password" placeholder="Mot de passe" class="mb-4" required>
      </div>

      <!-- Étape 2: Photo de profil ou avatar -->
      <div class="step hidden" data-step="2">
        <label class="block mb-2 font-semibold">Choisir un avatar ou une photo :</label>
        <div class="flex gap-4 justify-center mb-4">
          <img src="avatar1.png" class="avatar-option cursor-pointer w-16 h-16 rounded-full border-2" data-avatar="avatar1.png">
          <img src="avatar2.png" class="avatar-option cursor-pointer w-16 h-16 rounded-full border-2" data-avatar="avatar2.png">
          <img src="avatar3.png" class="avatar-option cursor-pointer w-16 h-16 rounded-full border-2" data-avatar="avatar3.png">
        </div>
        <input type="file" name="photo" accept="image/*" class="mb-4">
        <input type="hidden" name="avatar">
      </div>

      <!-- Navigation -->
      <div class="flex justify-between">
        <button type="button" id="prevBtn" class="hidden bg-gray-300 px-4 py-2 rounded">Précédent</button>
        <button type="button" id="nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Suivant</button>
        <button type="submit" id="submitBtn" class="hidden bg-green-500 text-white px-4 py-2 rounded">S'inscrire</button>
      </div>
    </form>
  </div>

  <script>
    const form = document.getElementById('multiStepForm');
    const steps = document.querySelectorAll('.step');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const avatarOptions = document.querySelectorAll('.avatar-option');

    let currentStep = 0;

    function showStep(index) {
      steps.forEach((step, i) => {
        step.classList.toggle('hidden', i !== index);
      });
      prevBtn.classList.toggle('hidden', index === 0);
      nextBtn.classList.toggle('hidden', index === steps.length - 1);
      submitBtn.classList.toggle('hidden', index !== steps.length - 1);
    }

    avatarOptions.forEach(option => {
      option.addEventListener('click', () => {
        avatarOptions.forEach(o => o.classList.remove('ring-2', 'ring-blue-500'));
        option.classList.add('ring-2', 'ring-blue-500');
        form.avatar.value = option.dataset.avatar;
      });
    });

    nextBtn.addEventListener('click', () => {
      if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
      }
    });

    prevBtn.addEventListener('click', () => {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    });

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      try {
        const response = await axios.post('register.php', formData);
        alert('Inscription réussie !');
        form.reset();
        showStep(0);
      } catch (err) {
        alert('Erreur lors de l'inscription.');
      }
    });

    showStep(currentStep);
  </script>


</body>
</html>