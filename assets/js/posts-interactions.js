// FONCTION POUR CHARGER LES COMMENTAIRES
async function loadComments(postId, container) {
    try {
        const response = await axios.get(`actions/get-comments.php?post_id=${postId}`);
        container.innerHTML = response.data;

        initShowMoreButtons(container);
    } catch(error) {
        container.innerHTML = '<p class="text-red-500 text-center text-sm">Erreur de chargement</p>';
    }
}

// GESTION DES BOUTONS "VOIR PLUS/MOINS
function initShowMoreButtons(container) {
    const commentSection = container.querySelector('.commentaire-section');
    if (!commentSection) return;
    
    const showMoreBtn = commentSection.querySelector('.show-more-btn');
    const showLessBtn = commentSection.querySelector('.show-less-btn');
    const comments = commentSection.querySelectorAll('.comment-item');
    
    if (showMoreBtn && showLessBtn && comments.length > 0) {
        // Enlever les anciens écouteurs
        const newShowMoreBtn = showMoreBtn.cloneNode(true);
        const newShowLessBtn = showLessBtn.cloneNode(true);
        showMoreBtn.parentNode.replaceChild(newShowMoreBtn, showMoreBtn);
        showLessBtn.parentNode.replaceChild(newShowLessBtn, showLessBtn);
        
        // Bouton "Voir plus"
        newShowMoreBtn.addEventListener('click', () => {
            comments.forEach(item => item.classList.remove('hidden'));
            newShowMoreBtn.classList.add('hidden');
            newShowLessBtn.classList.remove('hidden');
        });
        
        // Bouton "Voir moins"
        newShowLessBtn.addEventListener('click', () => {
            comments.forEach((item, index) => {
                if (index >= 2) item.classList.add('hidden');
            });
            newShowMoreBtn.classList.remove('hidden');
            newShowLessBtn.classList.add('hidden');
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    
    // Charger automatiquement tous les commentaires au démarrage
    document.querySelectorAll('.post-block').forEach(post => {
        const postId = post.dataset.postId;
        const commentsContainer = post.querySelector('.commentsContainer');
        
        if (postId && commentsContainer) {
            loadComments(postId, commentsContainer);
        }
    });
    
    // GESTION DES LIKES
    document.querySelectorAll('.like-section').forEach(section => {
        section.addEventListener('click', async function() {
            const postId = this.dataset.postId;
            const icon = this.querySelector('.like-icon');
            const count = this.querySelector('.like-count');
            
            try {
                const response = await axios.post('actions/toggle-like.php', { post_id: postId });
                
                if(response.data.success) {
                    const isLiked = response.data.liked;
                    const newCount = response.data.count;
                    
                    // Mettre à jour l'icône
                    if(isLiked) {
                        icon.classList.remove('text-gray-700');
                        icon.classList.add('text-red-500');
                        icon.setAttribute('fill', 'currentColor');
                        icon.setAttribute('stroke-width', '0');
                    } else {
                        icon.classList.remove('text-red-500');
                        icon.classList.add('text-gray-700');
                        icon.setAttribute('fill', 'none');
                        icon.setAttribute('stroke-width', '1.5');
                    }
                    
                    // Mettre à jour le compteur
                    count.textContent = newCount;
                }
            } catch(error) {
                // console.error('Erreur like:', error);
            }
        });
    });
    
    // GESTION DES FAVORIS
    document.querySelectorAll('.favorite-section').forEach(section => {
        section.addEventListener('click', async function() {
            const postId = this.dataset.postId;
            const icon = this.querySelector('.favorite-icon');
            let countSpan = this.querySelector('.favorite-count');
            
            try {
                const response = await axios.post('actions/toggle-favorite.php', { post_id: postId });
                
                if(response.data.success) {
                    const isFavorited = response.data.favorited;
                    const newCount = response.data.count;
                    
                    // Mettre à jour l'icône
                    if(isFavorited) {
                        icon.classList.remove('text-gray-700');
                        icon.classList.add('text-yellow-500');
                        icon.setAttribute('fill', 'currentColor');
                    } else {
                        icon.classList.remove('text-yellow-500');
                        icon.classList.add('text-gray-700');
                        icon.setAttribute('fill', 'none');
                    }
                    
                    // Mettre à jour le compteur
                    if(newCount > 0) {
                        if(!countSpan) {
                            countSpan = document.createElement('span');
                            countSpan.className = 'favorite-count'; 
                            this.appendChild(countSpan);
                        }
                        countSpan.textContent = newCount;
                    } else {
                        if(countSpan) countSpan.remove();
                    }
                }
            } catch(error) {
                // console.error('Erreur favori:', error);
            }
        });
    });
    
    // AFFICHER/MASQUER LE FORMULAIRE DE COMMENTAIRE
    document.querySelectorAll('.comment-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const postBlock = this.closest('.post-block');
            const commentsBlock = postBlock.querySelector('.comments-block');
            
            // Toggle la visibilité du formulaire uniquement
            commentsBlock.classList.toggle('hidden');
            commentsBlock.classList.toggle('flex');
        });
    });
    
    // ENVOYER UN COMMENTAIRE
    document.querySelectorAll('.commentButton').forEach(btn => {
        btn.addEventListener('click', async function() {
            const block = this.closest('.comments-block');
            const input = block.querySelector('.commentInput');
            const postId = block.querySelector('.postId').value;
            const comment = input.value.trim();
            
            if(!comment) return;
            
            try {
                const response = await axios.post('actions/add-comment.php', {
                    post_id: postId,
                    comment: comment
                });
                
                if(response.data.success) {
                    input.value = '';
                    
                    // Recharger les commentaires
                    const commentsContainer = this.closest('.post-block').querySelector('.commentsContainer');
                    await loadComments(postId, commentsContainer);
                    
                    // Mettre à jour le compteur
                    const countElement = this.closest('.post-block').querySelector('.comment-count');
                    countElement.textContent = response.data.total_comments;
                }
            } catch(error) {
                // console.error('Erreur commentaire:', error);
            }
        });
    });
    
    // ENVOI AVEC ENTER
    document.querySelectorAll('.commentInput').forEach(textarea => {
        textarea.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const btn = textarea.closest('.comments-block').querySelector('.commentButton');
                if(btn) btn.click();
            }
        });
    });


    // Actualisation intelligente en temps réel
    setInterval(async () => {
        document.querySelectorAll('.post-block').forEach(async post => {
            const postId = post.dataset.postId;
            
            try {
                const stats = await axios.get(`actions/get-post-stats.php?post_id=${postId}`);
                
                if(stats.data.success) {
                    // Mettre à jour les compteurs avec vérification
                    const likeCount = post.querySelector('.like-count');
                    const commentCount = post.querySelector('.comment-count');
                    const favoriteCount = post.querySelector('.favorite-count');
                    
                    if(likeCount) likeCount.textContent = stats.data.likes;
                    
                    // Recharger les commentaires si le nombre a changé
                    // const currentCommentCount = parseInt(commentCount?.textContent || '0');
                    if(commentCount !== stats.data.comments) {
                        commentCount.textContent = stats.data.comments;
                        
                        const commentsContainer = post.querySelector('.commentsContainer');
                        if(commentsContainer) {
                            await loadComments(postId, commentsContainer);
                        }
                    }
                    
                    // Mettre à jour le compteur de favoris
                    if(stats.data.favorites > 0) {
                        if(favoriteCount) {
                            favoriteCount.textContent = stats.data.favorites;
                        } else {
                            const favoriteSection = post.querySelector('.favorite-section');
                            if(favoriteSection && !favoriteSection.querySelector('.favorite-count')) {
                                const span = document.createElement('span');
                                span.className = 'favorite-count';
                                span.textContent = stats.data.favorites;
                                favoriteSection.appendChild(span);
                            }
                        }
                    } else {
                        if(favoriteCount) favoriteCount.remove();
                    }
                    
                    // Mettre à jour l'état des icônes
                    const likeIcon = post.querySelector('.like-icon');
                    if(likeIcon && stats.data.user_liked !== undefined) {
                        if(stats.data.user_liked) {
                            likeIcon.classList.remove('text-gray-700');
                            likeIcon.classList.add('text-red-500');
                            likeIcon.setAttribute('fill', 'currentColor');
                            likeIcon.setAttribute('stroke-width', '0');
                        } else {
                            likeIcon.classList.remove('text-red-500');
                            likeIcon.classList.add('text-gray-700');
                            likeIcon.setAttribute('fill', 'none');
                            likeIcon.setAttribute('stroke-width', '1.5');
                        }
                    }
                    
                    const favoriteIcon = post.querySelector('.favorite-icon');
                    if(favoriteIcon && stats.data.user_favorited !== undefined) {
                        if(stats.data.user_favorited) {
                            favoriteIcon.classList.remove('text-gray-700');
                            favoriteIcon.classList.add('text-yellow-500');
                            favoriteIcon.setAttribute('fill', 'currentColor');
                        } else {
                            favoriteIcon.classList.remove('text-yellow-500');
                            favoriteIcon.classList.add('text-gray-700');
                            favoriteIcon.setAttribute('fill', 'none');
                        }
                    }
                }
            } catch(error) {
                
            }
        });
    }, 10000); 
    
});