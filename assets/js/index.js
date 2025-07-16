const openNotification = document.getElementById('open-notifications');
const closeNotification = document.getElementById('close-notifications');
const popupNotification = document.getElementById('popup-notifications');

openNotification.addEventListener('click', () => {
    popupNotification.style.display = 'block';
})

closeNotification.addEventListener('click', () => {
    popupNotification.style.display = 'none';
})

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



// Dynamisme d'ajout  d'un ami
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-add-friend').forEach(button => {
        button.addEventListener('click', async () => {
            const receiverId = button.dataset.userId;

            try {
                const response = await axios.post('actions/add-friend-action.php', {
                    receiver_id: receiverId
                });

                if (response.data.success) {
                    // alert("Invitation envoyée !");
                    button.closest('.suggestion-item').remove(); // retire la suggestion
                    const card = `
  <div class="invitation-item flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md py-2 px-3 mb-4 text-sm">
    <div class="flex gap-3 justify-center">
      <div class="flex gap-3 items-center justify-center">
        <img class="w-10 h-10 object-cover rounded" src="profile-pic/${button.dataset.profilePic}" alt="">
        <div class="break-words w-44">Invitation envoyée à <strong>${button.dataset.userName}</strong></div>
      </div>
      <div class="text-gray-600 text-sm font-bold">À l’instant</div>
    </div>
    <button class="btn-cancel-invite flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm w-full text-red-500 shadow-sm outline-0 cursor-pointer" 
    data-receiver-id="${receiverId}"
    data-user-name="${button.dataset.userName}"
    data-profile-pic="${button.dataset.profilePic}">
      Annuler
    </button>
  </div>
`;

    // document.getElementById('invites-limited').insertAdjacentHTML('beforeend', card);

                } else {
                    alert(response.data.message);
                }
            } catch (error) {
                console.error("Erreur :", error);
                alert("Erreur lors de l'envoi de l'invitation.");
            }
        });
    });

    // Bouton Retirer
    document.querySelectorAll('.btn-remove-suggestion').forEach(button => {
        button.addEventListener('click', () => {
            // button.closest('.suggestion-item').remove();
            // Retirer utilisateur
            button.addEventListener('click', async () => {
                const ignoredId = button.dataset.userId;

                try {
                    await axios.post('actions/ignore-suggestion-action.php', {
                        ignored_id: ignoredId
                    });

                    button.closest('.suggestion-item').remove();
                } catch (e) {
                    console.error("Erreur suppression suggestion :", e);
                }
            });
        });
    });

});


// Dynamisme d'annulation d'invitation envoyée
document.querySelectorAll('.btn-cancel-invite').forEach(button => {
    button.addEventListener('click', async () => {
        const receiverId = button.dataset.receiverId;
        console.log(receiverId)
        try {
            const response = await axios.post('actions/cancel-invitation-action.php', {
                receiver_id: receiverId
            });

            if (response.data.success) {
                console.log('Invitation annulée.');
                button.closest('.invitation-item').remove(); // Supprimer visuellement
                // Recrée dynamiquement la suggestion
                const suggestionHTML = `
                <div class="suggestion-item bg-white rounded-2xl shadow-md py-3 px-2 mb-4 text-sm">
                <div class="flex items-center gap-3 justify-center">
                    <img class="w-10 h-10 object-cover rounded" src="profile-pic/${button.dataset.profilePic}" alt="">
                    <div class="flex gap-3 flex-col justify-center">
                    <strong>${button.dataset.userName}</strong>
                    <div class="flex gap-2">
                        <button class="flex items-center justify-center bg-[#2563EB] text-white rounded-xl px-5 py-2 text-sm whitespace-nowrap cursor-pointer outline-0 btn-add-friend" style="width: 90px;" data-user-id="${receiverId}">Ajouter ami</button>
                        <button class="flex items-center justify-center border border-gray-200 rounded-xl px-5 py-2 text-sm cursor-pointer outline-0 btn-remove-suggestion" style="width: 90px;" data-user-id="${receiverId}">Retirer</button>
                    </div>
                    </div>
                </div>
                </div>
                `;

                // L'ajoute à la suggestion limitée
                document.getElementById('suggestion-limited').insertAdjacentHTML('beforeend', suggestionHTML);

            } else {
                console.log(response.data.message || 'Erreur.');
            }
        } catch (error) {
            console.log(receiverId)
            console.error("Erreur d’annulation :", error);
            alert("Erreur serveur lors de l’annulation.");
        }
    });
});


function sendComment(event) {
    const button = event.currentTarget;
    const container = button.closest('.comments-block'); 

    const comment = container.querySelector('.commentInput').value.trim();
    const postId = container.querySelector('.postId').value;
    const uniqueId = container.querySelector('.uniqueId').value;

    console.log(comment)
    console.log(postId)
    console.log(uniqueId)

    if (comment.trim() === '') return;

    axios.post('actions/envoi-commentaire-action.php', {
        comment: comment,
        post_id: postId,
        unique_id: uniqueId
    })
    .then(response => {
        console.log(response.data);
        container.querySelector('.commentInput').value = '';
        loadComments(postId, commentsContainer); // recharge les commentaires du post
    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi', error);
    });
}

document.querySelectorAll('.commentButton').forEach(button => {
    button.addEventListener('click', sendComment);
})


function loadComments(postId, container) {
    axios.get('actions/afficher-commentaire-action.php', {
        params: {
            post_id: postId
        }
    })
    .then(response => {
        if (container) {
            container.innerHTML = response.data;
        }
        const commentBlocks = document.querySelectorAll('.comments-block');
        if (!commentBlocks) return;

        commentBlocks.forEach(block => {
            const comments = block.querySelectorAll('.comment-item');
            const showMoreBtn = document.querySelector('.show-more');
            const showLessBtn = document.querySelector('.show-less');

            console.log(comments)
            console.log(showMoreBtn)
            console.log(showLessBtn)

            if (showMoreBtn && showLessBtn) {
                showMoreBtn.addEventListener('click', () => {
                    comments.forEach(item => item.classList.remove('hidden'));
                    showMoreBtn.classList.add('hidden');
                    showLessBtn.classList.remove('hidden');
                });

                showLessBtn.addEventListener('click', () => {
                    comments.forEach((item, index) => {
                        if (index >= 2) item.classList.add('hidden');
                    });
                    showMoreBtn.classList.remove('hidden');
                    showLessBtn.classList.add('hidden');
                });
            }
        });
    })
    .catch(error => {
        console.error('Erreur chargement commentaires', error);
    });
}

// Charger les commentaires au démarrage
window.onload = () => {
    document.querySelectorAll('.post-block').forEach(post => {
        const postId = post.dataset.postId;
        const commentsContainer = post.querySelector('.commentsContainer');
        if (postId && commentsContainer) {
            loadComments(postId, commentsContainer);
        }
    });
};






