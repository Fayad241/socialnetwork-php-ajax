document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('.form-post');
    const textarea = form.querySelector('textarea');
    const fileInput = document.getElementById('image-upload');

    const preview = document.getElementById('preview');
    const previewBox = document.getElementById('image-preview');

    // RELOAD LOCALSTORAGE
    if (localStorage.getItem("post_content")) {
        textarea.value = localStorage.getItem("post_content");
    }

    if (localStorage.getItem("post_image")) {
        preview.src = localStorage.getItem("post_image");
        previewBox.classList.remove("hidden");
    }

    // Sauvegarde du texte
    textarea.addEventListener("input", () => {
        localStorage.setItem("post_content", textarea.value);
    });

    // Sauvegarde de l’image
    document.getElementById('image-upload').addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result;
                previewBox.classList.remove('hidden');

                // sauvegarde dans localStorage
                localStorage.setItem("post_image", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

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

    // SUBMIT
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideFormError();

        const content = textarea.value.trim();
        const file = fileInput.files[0];

        // Aucun champ rempli
        if (!content && !file) {
            showFormError("Veuillez entrer un texte ou une image.");
            return;
        }

        // Longueur texte
        if (content.length > 1000) {
            showFormError("Votre texte est trop long (maximum 1000 caractères).");
            return;
        }

        // Check image
        if (file) {
            const allowed = ["image/jpeg", "image/png", "image/webp"];
            if (!allowed.includes(file.type)) {
                showFormError("Format d’image non autorisé (formats acceptés : JPG, JPEG, PNG, WEBP).");
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                showFormError("L’image est trop lourde (max 5 MB).");
                return;
            }
        }

        const formData = new FormData();
        if (content) formData.append('content', content);
        if (file) formData.append('img-publication', file);

        try {
            const response = await axios.post('../../actions/posts-action.php', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            if (response.data.success) {

                // Nettoyage localStorage
                localStorage.removeItem("post_content");
                localStorage.removeItem("post_image");

                textarea.value = '';
                fileInput.value = '';
                previewBox.classList.add('hidden');
                preview.src = '';

                window.location.href = '../../home.php';
            } else {
                showFormError(response.data.message || "Erreur inconnue.");
            }

        } catch (error) {
            console.error("Erreur lors de l'envoi :", error);
            showFormError("Une erreur est survenue lors de l’enregistrement.");
        }
    });
});
