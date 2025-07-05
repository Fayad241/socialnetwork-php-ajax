const form = document.getElementById('multiStepForm');
    const steps = document.querySelectorAll('.step');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');

    let currentStep = 0;

    function showStep(index) {
      steps.forEach((step, i) => {
        step.classList.toggle('hidden', i !== index);
      });
      prevBtn.classList.toggle('hidden', index === 0);
      nextBtn.classList.toggle('hidden', index === steps.length - 1);
      submitBtn.classList.toggle('hidden', index !== steps.length - 1);
    }

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

    

    showStep(currentStep);



//  Gestion dynamisme Photo de profil
  const fileInput = document.getElementById('profileUpload');
  const previewImg = document.getElementById('previewImage');
  const fileName = document.getElementById('fileName');

  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (!file) return;

    fileName.textContent = file.name;

    const reader = new FileReader();
    reader.onload = (e) => {
      previewImg.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });

  function handleDrop(event) {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;

    fileInput.files = event.dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
  }