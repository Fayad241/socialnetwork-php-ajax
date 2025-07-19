    const steps = document.querySelectorAll('.step');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');

    let currentStep = parseInt(sessionStorage.getItem("currentStep")) || 0; 

    function showStep(index) {
      steps.forEach((step, i) => {
        step.classList.toggle('hidden', i !== index);
      });
      prevBtn.classList.toggle('hidden', index === 0);
      nextBtn.classList.toggle('hidden', index === steps.length - 1);
      submitBtn.classList.toggle('hidden', index !== steps.length - 1);

      sessionStorage.setItem("currentStep", index);
    }

    nextBtn.addEventListener('click', async () => {
        if(currentStep === 0) {

            let stepValid = validateStep0WithoutEmail(); 
            
            if(!stepValid) return;
            
            const emailValid = await validateEmail(email);
            
            if(emailValid) {
                currentStep++;
                showStep(currentStep);
            }
        } 
        else if(currentStep === 1) {
            if(validateStep1()) {
                currentStep++;
                showStep(currentStep);
            }
        }
    });
    // console.log(currentStep)


    prevBtn.addEventListener('click', () => {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    });

    function showError(input, message) {
        const formControl = input.parentElement;
        const errorElement = document.createElement('div');
        errorElement.className = 'text-red-500 text-sm mt-1';
        errorElement.textContent = message;
        
        const existingError = formControl.querySelector('.text-red-500');
        if(existingError) {
            formControl.removeChild(existingError);
        }
        
        formControl.appendChild(errorElement);
        input.classList.add('border-red-500');

        if(message === null) return;
    }

    function clearError(input) {
        showError(input, null);
        input.classList.remove('border-red-500');
    }

    function validateStep0WithoutEmail() {
        let valid = true;

        if (!validateName(firstname)) valid = false;
        if (!validateName(lastname)) valid = false;
        if (!validateBio(bioUser)) valid = false;
        if (!validatePassword(password)) valid = false;
        if (!validatePasswordMatch()) valid = false;

        clearError(input)
        return valid;
    }

    const lastname = document.querySelector('input[name="last-name"]');
    const firstname = document.querySelector('input[name="first-name"]');
    const email = document.querySelector('input[name="email"]');
    const bioUser = document.querySelector('textarea[name="bio"]');
    const password = document.querySelector('input[name="password"]');
    const confirmPassword = document.querySelector('input[name="confirm-password"]');

    function validateName(input) {
        const regex = /^[a-zA-ZÀ-ÿ\s'-]+$/;
        if (!input.value.trim()) {
            showError(input, "Ce champ est requis");
            return false;
        }
        else if(!regex.test(input.value.trim())) {
            showError(input, "Ne doit pas contenir de chiffres");
            return false;
        }

        clearError(input)
        return true;
    }

    async function validateEmail(input) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const emailValue = input.value.trim();
        if (!emailValue) {
            showError(input, "Email requis");
            return false;
        }
        else if (!regex.test(input.value.trim())) {
            showError(input, "Email invalide!");
            return false;
        } 

        try {
            const response = await axios.post("../../actions/register-action.php", {
                mode: 'check-email',
                email: emailValue
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                transformRequest: [function (data) {
                    return new URLSearchParams(data).toString();
                }]
            });

            if(response.data.exists) {
                showError(input, "Cet email est déjà utilisé");
                return false;
            }
            return true;
        } catch (error) {
            console.error("Erreur de vérification email :", error);
            return false;
        }

        // clearError(input)
    }

    function validateStep0WithoutEmail() {
        let valid = true;

        if (!validateName(firstname)) valid = false;
        if (!validateName(lastname)) valid = false;
        if (!validateBio(bioUser)) valid = false;
        if (!validatePassword(password)) valid = false;
        if (!validatePasswordMatch()) valid = false;

        // clearError(input)
        return valid;
    }

    function validateBio(input) {
        if(bioUser.value.length > 500) {
            showError(input, "Votre biographie ne doit pas dépasser 500 caractères");
            return false;
        }

        clearError(input)
        return true;
    }

    function validatePassword(input) {
        if (!input.value.trim()) {
            showError(input, "Mot de passe requis");
            return false;
        }
        else if (input.value.length < 8) {
            showError(input, "Le mot de passe doit contenir au moins 8 caractères");
            return false;
        }

        clearError(input)
        return true;
    }

    function validatePasswordMatch() {
        if (!confirmPassword.value.trim()) {
            showError(confirmPassword, "Veuillez confirmer votre mot de passe");
            return false;
        }
        else if (password.value !== confirmPassword.value) {
            showError(confirmPassword, "Les mots de passe ne correspondent pas");
            return false;
        }
        return true;

        clearError(input)
    }

    firstname.addEventListener('blur', () => validateName(firstname));
    lastname.addEventListener('blur', () => validateName(lastname));
    email.addEventListener('blur', async () => await validateEmail(email));
    bioUser.addEventListener('blur', () => validateBio(bioUser));
    password.addEventListener('blur', () => validatePassword(password));
    confirmPassword.addEventListener('blur', validatePasswordMatch);

    async function validateStep0() {
        let valid = true;

        if (!validateName(firstname)) valid = false;
        if (!validateName(lastname)) valid = false;
        if (!validateBio(bioUser)) valid = false;
        if (!validatePassword(password)) valid = false;
        if (!validatePasswordMatch()) valid = false;

        return valid;
    }

    function validateStep1() {
        const genderInput = document.querySelector('input[name="gender"]');
        const dateInput = document.querySelector('input[name="birthday"]');

        let valid = true;

        function validateGender(input) {
            if(!genderInput.value.trim()) {
                showError(input, "Veuillez indiquer votre sexe");
                return false;
            }
            return true;
        }

        function validateBirthday(input) {
            if(!dateInput.value.trim()) {
                showError(input, "Veuillez indiquer votre date de naissance");
                return false;
            }
            return true;
        }

        const birthDate = new Date(dateInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const month = today.getMonth() - birthDate.getMonth();
        if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 15) {
            showError(dateInput, "Vous devez avoir au moins 15 ans!");
            return false;
        }


        if (!validateGender(genderInput)) valid = false;
        if (!validateBirthday(dateInput)) valid = false;

        return valid;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const genderOptions = document.querySelectorAll('.gender-option');
        const genderInput = document.querySelector('input[name="gender"]');

        genderOptions.forEach(button => {
            button.addEventListener('click', () => {
                genderOptions.forEach(b => b.classList.remove('bg-blue-500', 'bg-pink-500', 'bg-purple-500', 'text-white', 'font-semibold'));

                if(button.dataset.value === "homme") {                    
                    button.classList.add('bg-blue-500', 'text-white', 'font-semibold');
                } else if(button.dataset.value === "femme") {
                    button.classList.add('bg-pink-500', 'text-white', 'font-semibold');
                } else if(button.dataset.value === "autre") {
                    button.classList.add('bg-purple-500', 'text-white', 'font-semibold');
                }
                genderInput.value = button.dataset.value;

            });
        });
    })

    function validateStep2() {
        const profilePic = document.querySelector('input[name="profile-pic"]');
        // console.log("validateStep2 exécutée");
        let valid = true;

        function validateProfile(input) {
            if(!input.files || input.files.length === 0) {
                showError(input, "Veuillez choisir une photo de profil");
                return false;
            } 

            const file = input.files[0];
            const validTypes = ["image/jpeg", "image/jpg", "image/png", "image/webp"];

            if (!validTypes.includes(file.type)) {
                showError(input, "Format non supporté. Utilisez JPEG, JPG, PNG ou WebP.");
                return false;
            }

            return true;
        }

        if(!validateProfile(profilePic)) valid = false;

        return valid;
    }

    showStep(currentStep);


    const form = document.getElementById('multiStepForm');
    form.addEventListener('submit', async(e) => {
        e.preventDefault();

        if(!validateStep2()) return;
        const formData = new FormData(form);
        formData.append('mode', 'register'); 

        try {
            const response = await axios.post("../../actions/register-action.php", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            })
            
            form.reset();
            localStorage.clear();
            sessionStorage.removeItem("currentStep");

            // console.log(response.data);

            // Vérifier la réponse
            if (response.data.success) {
                sessionStorage.setItem('user', JSON.stringify(response.data.user));
                window.location.href = response.data.redirect;
            } else {
                console.error('Erreur serveur:', response.data.error);
            }
        } 
        
        catch(error) {
            console.error("Erreur axios: ", error.response ? error.response.data : error.message);
            // console.log("erreur lors de l'envoi");
        }

    });

    document.querySelectorAll('input').forEach((input) => {
        const name = input.name;
        if(name && input.type !== "file" && localStorage.getItem(name)) {
            input.value = localStorage.getItem(name);
        }

        input.addEventListener("input", () => {
            if(input.type !== "file") {
                localStorage.setItem(name, input.value);
            }
        })
    })


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
