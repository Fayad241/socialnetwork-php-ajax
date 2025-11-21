// Ouvrir et fermer la liste de conversations
const openMessage = document.getElementById('open-messages');
const closeMessage = document.getElementById('close-messages');
const popupMessage = document.getElementById('popup-messages');

openMessage.addEventListener('click', () => {
    popupMessage.style.display = 'block';
})

closeMessage.addEventListener('click', () => {
    popupMessage.style.display = 'none';
})


document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('toggle-suggestions');
    const limited = document.getElementById('suggestion-limited');
    const full = document.getElementById('suggestion-full');

    if(btn && limited && full) {
        let expanded = false;

        btn.addEventListener('click', () => {
        expanded = !expanded;

        if (expanded) {
            limited.classList.add('hidden');
            full.classList.remove('hidden');
            btn.textContent = "Voir moins";
        } else {
            full.classList.add('hidden');
            limited.classList.remove('hidden');
            btn.textContent = "Voir plus";
        }
        });
    }
});

document.getElementById('toggle-invites')?.addEventListener('click', function () {
    const full = document.getElementById('invites-full');
    const limited = document.getElementById('invites-limited');

    if (full.classList.contains('hidden')) {
        full.classList.remove('hidden');
        this.textContent = 'Voir moins';
    } else {
        full.classList.add('hidden');
        this.textContent = 'Voir plus';
    }
});



// POSTER DU TEXTE RAPIDEMENT
const form = document.querySelector('.form-post');
const textarea = form.querySelector('.text-post');
const submitBtn = form.querySelector('button');

// LOCAL STORAGE
if (localStorage.getItem("content_post")) {
    textarea.value = localStorage.getItem("content_post");
    autoResize(textarea);
}

textarea.addEventListener("input", () => {
    localStorage.setItem("content_post", textarea.value);
    autoResize(textarea);
});

// AUTO RESIZE
function autoResize(el) {
    el.style.height = "auto";
    el.style.height = el.scrollHeight + "px";
}

// SHOW/HIDE ERROR
function showFormError(message) {
    const errorBox = document.getElementById('post-error');
    errorBox.textContent = message;
    errorBox.classList.remove('hidden');
}

function hideFormError() {
    const errorBox = document.getElementById('post-error');
    errorBox.textContent = "";
    errorBox.classList.add('hidden');
}

// SUBMIT VIA ENTER
textarea.addEventListener("keydown", (e) => {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        submitBtn.click();
    }
});

// SUBMIT FORM
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    hideFormError();

    const content = textarea.value.trim();

    if (!content) {
        showFormError("Veuillez entrer un texte");
        return;
    }

    if (content.length > 1000) {
        showFormError("Votre texte est trop long (maximum 1000 caractères).");
        return;
    }

    const formData = new FormData();
    formData.append('content', content);

    // ANIMATION : LOADING
    submitBtn.disabled = true;
    const originalText = submitBtn.innerHTML;

    submitBtn.innerHTML = `
        <svg class="animate-spin h-4 w-4 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    `;

    try {
        const response = await axios.post('actions/posts-action.php', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        if (response.data.success) {
            localStorage.removeItem("content_post");

            textarea.value = '';
            autoResize(textarea);

            window.location.href = 'home.php';
        } else {
            showFormError(response.data.message || "Erreur inconnue.");
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        showFormError("Une erreur est survenue lors de l’enregistrement.");
    }

    // Retour à la normale
    submitBtn.disabled = false;
    submitBtn.innerHTML = originalText;
});













