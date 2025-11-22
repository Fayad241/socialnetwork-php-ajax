document.addEventListener('DOMContentLoaded', () => {

    const textarea = document.getElementById('story-text');
    const preview = document.getElementById('preview');
    const previewBox = document.getElementById('image-preview');


    // RELOAD LOCALSTORAGE
    if (localStorage.getItem("story_content")) {
        textarea.value = localStorage.getItem("story_content");
    }

    if (localStorage.getItem("story_image")) {
        preview.src = localStorage.getItem("story_image");
        previewBox.classList.remove("hidden");
    }

    // Sauvegarde du texte
    textarea.addEventListener("input", () => {
        localStorage.setItem("story_content", textarea.value);
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
                localStorage.setItem("story_image", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
})