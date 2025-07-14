document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    // Vérifie si l'utilisateur est déjà connecté
    // if (sessionStorage.getItem('user')) {
    //     window.location.href = '../../home.php';
    // }

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
    }

    function clearError(input) {
        const formControl = input.parentElement;
        const errorElement = formControl.querySelector('.text-red-500');
        if(errorElement) {
            formControl.removeChild(errorElement);
        }
        input.classList.remove('border-red-500');
    }

    function validateEmail(input) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!input.value.trim()) {
            showError(input, "Email requis");
            return false;
        } else if (!regex.test(input.value.trim())) {
            showError(input, "Email invalide");
            return false;
        }
        clearError(input);
        return true;
    }

    function validatePassword(input) {
        if (!input.value.trim()) {
            showError(input, "Mot de passe requis");
            return false;
        }
        clearError(input);
        return true;
    }

    emailInput.addEventListener('blur', () => validateEmail(emailInput));
    passwordInput.addEventListener('blur', () => validatePassword(passwordInput));

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const isEmailValid = validateEmail(emailInput);
        const isPasswordValid = validatePassword(passwordInput);

        if (!isEmailValid || !isPasswordValid) {
            return;
        }

        try {
            const response = await axios.post('../../actions/login-action.php', {
                email: emailInput.value.trim(),
                password: passwordInput.value.trim()
            }, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            if (response.data.error) {
                showError(emailInput, response.data.error);
                showError(passwordInput, '');
                return;
            }

            if (response.data.success) {
                // Stockage des données utilisateur dans sessionStorage
                sessionStorage.setItem('user', JSON.stringify(response.data.user));
                window.location.href = response.data.redirect;
            }
        } catch (error) {
            console.error('Erreur:', error);
            showError(emailInput, 'Une erreur est survenue');
            showError(passwordInput, '');
        }
    });
});

// Vérifier l'état de connexion (à utiliser sur d'autres pages)
// function checkAuth() {
//     const user = JSON.parse(sessionStorage.getItem('user'));
//     if (!user) {
//         window.location.href = 'login.php';
//     }
//     return user;
// }

