document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const textarea = form.querySelector('textarea');
    const fileInput = document.getElementById('image-upload');

    // Affiche l'image sélectionnée
    document.getElementById('image-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview').src = event.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Gestion soumission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData();
        const content = textarea.value.trim();
       
        // Autoriser l’envoi même si seul l’un des deux est présent
        if (content) formData.append('content', content);
        if (fileInput.files[0]) formData.append('img-publication', fileInput.files[0]);
        
        if (fileInput.files[0]) {
            formData.append('img-publication', fileInput.files[0]);
        }

        if (!content && !fileInput.files[0]) {
            alert('Ajoutez un texte ou une image au minimum.');
            return;
        }

        formData.append('content', textarea.value.trim());
        
        try {
            const response = await axios.post('../../actions/posts-action.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (response.data.success) {
                textarea.value = '';
                fileInput.value = '';
                document.getElementById('image-preview').classList.add('hidden');
                document.getElementById('preview').src = '';
                window.location.href = '../../home.php';
            } else {
                alert(response.data.message || 'Erreur lors de la publication.');
            }
        } catch (error) {
            console.error("Erreur lors de l'envoi :", error);
            alert('Erreur serveur lors de la publication.');
        }
    });
});
