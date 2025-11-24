document.addEventListener('DOMContentLoaded', () => {

    const textarea = document.getElementById('story-text');
    const previewImg = document.getElementById('preview-image');
    const previewVideo = document.getElementById('preview-video');
    const previewBox = document.getElementById('preview-box');
    const mediaInput = document.getElementById('story-media');
    const durationInputs = document.querySelectorAll('input[name="duration"]');
    const publishBtn = document.getElementById('publish-btn');

    // RELOAD LOCALSTORAGE
    if (localStorage.getItem("story_content")) {
        textarea.value = localStorage.getItem("story_content");
    }

    if (localStorage.getItem("story_duration")) {
        const savedDuration = localStorage.getItem("story_duration");
        durationInputs.forEach(input => {
            if (input.value === savedDuration) {
                input.checked = true;
                input.dispatchEvent(new Event('change')); 
            }
        });
    }

    // Sauvegarde du texte
    textarea.addEventListener("input", () => {
        localStorage.setItem("story_content", textarea.value);
        updateCharacterCount();
    });

     // Sauvegarde Durée
    durationInputs.forEach(input => {
        input.addEventListener('change', () => {
            localStorage.setItem("story_duration", input.value);
        });
    });
  
    // Mis à jour nombre de character du textarea
    function updateCharacterCount() {
        document.getElementById('text-count').textContent = textarea.value.length;
    }

    mediaInput.addEventListener('change', function (e) {
        const media = e.target.files[0];
        if (!media) return;

        previewImg.classList.add('hidden');
        previewVideo.classList.add('hidden');

        const type = media.type;

        // IMAGE
        if (type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (event) => {
                previewImg.src = event.target.result;
                previewImg.classList.remove('hidden');
                previewBox.classList.remove('hidden');
            };
            reader.readAsDataURL(media);
        }

        // VIDEO
        else if (type.startsWith("video/")) {
            const videoURL = URL.createObjectURL(media);
            previewVideo.src = videoURL;
            previewVideo.classList.remove('hidden');
            previewBox.classList.remove('hidden');
        }
    })   

    // Bouton supprimer image
    const removeMediaBtn = document.createElement('button');
    removeMediaBtn.textContent = 'Supprimer l’image/vidéo';
    removeMediaBtn.type = 'button';
    removeMediaBtn.classList.add('text-red-500', 'text-sm', 'mt-2', 'cursor-pointer');
    previewBox.appendChild(removeMediaBtn);

    removeMediaBtn.addEventListener('click', () => {
        previewImg.src = "";
        previewVideo.src = "";
        previewImg.classList.add("hidden");
        previewVideo.classList.add("hidden");
        previewBox.classList.add('hidden');
        mediaInput.value = '';
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


    // Publier la story
    const btnPublishStory = document.querySelector('.btn-publish-story')
    btnPublishStory.addEventListener('click', async function() {
        
        const text = textarea.value;
        const media = mediaInput.files[0];
        const duration = document.querySelector('input[name="duration"]:checked').value;

        let mediaType = "";

        if (media.type.startsWith("image/")) {
            mediaType = "image";
        } else if (media.type.startsWith("video/")) {
            mediaType = "video";
        } else {
            return;
        }

        hideFormError();

        // Aucun champ rempli
        if (!text && !media) {
            showFormError("Veuillez entrer un texte ou une image/vidéo.");
            return;
        }

        // Longueur texte
        if (text.length > 200) {
            showFormError("Votre texte est trop long (maximum 200 caractères).");
            return;
        }

        // Check file
        if (media) {
            const allowed = ["image/jpg", "image/jpeg", "image/png", "image/gif", 'video/mp4', 'video/mov', 'video/avi', 'video/webm'];
            if (!allowed.includes(media.type)) {
                showFormError("Format d’image/vidéo non autorisé (formats acceptés : JPG, JPEG, PNG, GIF, mp4, mov, avi, webm).");
                return;
            }
            if (media.size > 10 * 1024 * 1024) {
                showFormError("L’image/vidéo est trop lourde (max 10 MB).");
                return;
            }
        }

        const formData = new FormData();
        if (media) formData.append('media', media);
        if (text) formData.append('text', text);
        formData.append("media_type", mediaType);
        formData.append('duration', duration);
        
        try {
            const response = await axios.post('../../actions/add-story.php', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            
            if (response.data.success) {
                // Afficher un message de succès
                publishBtn.classList.remove('from-blue-600', 'to-[#06B6D4]');
                publishBtn.classList.add('bg-green-500');
                publishBtn.textContent = '✓ Story publiée !';

                localStorage.removeItem("story_content");
                localStorage.removeItem("story_duration");

                textarea.value = '';
                mediaInput.value = '';
                previewImg.src = '';
                previewVideo.src = '';
                previewBox.classList.add('hidden');

                durationInputs.forEach(input => {
                    input.checked = input.value === '24'; 
                    input.dispatchEvent(new Event('change')); 
                });

                publishBtn.disabled = true;
                publishBtn.textContent = 'Publication en cours...';

                setTimeout(() => {
                    window.location.href = '../../home.php';
                }, 1000);
            } else {
                alert(response.data.message || 'Erreur lors de la publication');
                publishBtn.disabled = false;
                publishBtn.textContent = 'Publier ma story';
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors de la publication de la story');
            publishBtn.disabled = false;
            publishBtn.textContent = 'Publier ma story';
        }
    })
})