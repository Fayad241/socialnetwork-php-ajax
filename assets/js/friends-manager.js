document.addEventListener('DOMContentLoaded', () => {
    
    // CRÉATION DU MODAL
    createModalContainer();
    
    // TOGGLE INVITATIONS ENVOYÉES
    const toggleInvitesBtn = document.getElementById('toggle-invites');
    if (toggleInvitesBtn) {
        toggleInvitesBtn.addEventListener('click', function() {
            const invitesFull = document.getElementById('invites-full');
            const toggleText = this.querySelector('.toggle-text-sent-invites');

            if (!toggleText) return;
            
            if (invitesFull.classList.contains('hidden')) {
                invitesFull.classList.remove('hidden');
                toggleText.textContent = 'Voir moins';
            } else {
                invitesFull.classList.add('hidden');
                toggleText.textContent = 'Voir plus';
            }
        });
    }
    
    // TOGGLE SUGGESTIONS D'AMIS
    const toggleSuggestionsBtn = document.getElementById('toggle-suggestions');
    if (toggleSuggestionsBtn) {
        toggleSuggestionsBtn.addEventListener('click', function() {
            const suggestionsFull = document.getElementById('suggestion-full');
            const toggleText = this.querySelector('.toggle-text-suggested-friends');
            
            if (!toggleText) return; 

            if (suggestionsFull.classList.contains('hidden')) {
                suggestionsFull.classList.remove('hidden');
                toggleText.textContent = 'Voir moins';
            } else {
                suggestionsFull.classList.add('hidden');
                toggleText.textContent = 'Voir plus';
            }
        });
    }

    
    // ACCEPTER UNE INVITATION
    document.querySelectorAll('.btn-accept-invite').forEach(btn => {
        btn.addEventListener('click', async function() {
            const senderId = this.dataset.senderId;
            const userName = this.dataset.userName;
            const inviteItem = this.closest('.invitation-received-item');
            
            const confirmed = await showModal(
                'Accepter l\'invitation',
                `Voulez-vous accepter l'invitation de ${userName} ?`,
                'Accepter',
                'Annuler'
            );
            
            if (!confirmed) return;
            
            try {
                const response = await axios.post('actions/accept-invitation.php', {
                    sender_id: senderId
                });
                
                if (response.data.success) {
                    // Animation de suppression
                    inviteItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    inviteItem.style.opacity = '0';
                    inviteItem.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        inviteItem.remove();
                        updateReceivedInvitationsCount();
                        checkEmptyReceivedInvitations();
                    }, 300);
                    
                    showNotification(`Vous êtes maintenant ami avec ${userName}`, 'success');
                }
            } catch (error) {
                console.error('Erreur acceptation invitation:', error);
                showNotification('Erreur lors de l\'acceptation', 'error');
            }
        });
    });
    
    // REFUSER UNE INVITATION
    document.querySelectorAll('.btn-reject-invite').forEach(btn => {
        btn.addEventListener('click', async function() {
            const senderId = this.dataset.senderId;
            const userName = this.dataset.userName;
            const profilePic = this.dataset.profilePic;
            const inviteItem = this.closest('.invitation-received-item');
            
            const confirmed = await showModal(
                'Refuser l\'invitation',
                `Voulez-vous refuser l'invitation de ${userName} ?`,
                'Refuser',
                'Annuler'
            );
            
            if (!confirmed) return;
            
            try {
                const response = await axios.post('actions/reject-invitation.php', {
                    sender_id: senderId
                });
                
                if (response.data.success) {
                    inviteItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    inviteItem.style.opacity = '0';
                    inviteItem.style.transform = 'translateX(20px)';
                    
                    setTimeout(() => {
                        inviteItem.remove();
                        updateReceivedInvitationsCount();
                        checkEmptyReceivedInvitations();
                        
                        // Ajouter à la section suggestions
                        addToSuggestions(senderId, userName, profilePic);
                    }, 300);
                    
                    showNotification('Invitation refusée', 'info');
                }
            } catch (error) {
                console.error('Erreur rejet invitation:', error);
                showNotification('Erreur lors du refus', 'error');
            }
        });
    });
    
    // ANNULER UNE INVITATION ENVOYÉE
    document.querySelectorAll('.btn-cancel-invite').forEach(btn => {
        btn.addEventListener('click', async function() {
            const receiverId = this.dataset.receiverId;
            const userName = this.dataset.userName;
            const profilePic = this.dataset.profilePic;
            const inviteItem = this.closest('.invitation-sent-item');
            
            const confirmed = await showModal(
                'Annuler l\'invitation',
                `Voulez-vous annuler l'invitation envoyée à ${userName} ?`,
                'Annuler l\'invitation',
                'Retour'
            );
            
            if (!confirmed) return;
            
            try {
                const response = await axios.post('actions/cancel-invitation.php', {
                    receiver_id: receiverId
                });
                
                if (response.data.success) {
                    inviteItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    inviteItem.style.opacity = '0';
                    inviteItem.style.transform = 'scale(0.9)';
                    
                    setTimeout(() => {
                        inviteItem.remove();
                        updateSentInvitationsCount();
                        checkEmptySentInvitations();
                        
                        // Ajouter à la section suggestions
                        addToSuggestions(receiverId, userName, profilePic);
                    }, 300);
                    
                    showNotification('Invitation annulée', 'info');
                }
            } catch (error) {
                console.error('Erreur annulation invitation:', error);
                showNotification('Erreur lors de l\'annulation', 'error');
            }
        });
    });
    

    // AJOUTER UN AMI
    document.querySelectorAll('.btn-add-friend').forEach(btn => {
        btn.addEventListener('click', async function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            const profilePic = this.dataset.profilePic;
            const suggestionItem = this.closest('.suggestion-item');
            
            // Désactiver le bouton temporairement
            this.disabled = true;
            this.textContent = 'Envoi...';
            
            try {
                const response = await axios.post('actions/send-friend-request.php', {
                    receiver_id: userId
                });
                
                if (response.data.success) {
                    // Retirer de la liste des suggestions
                    suggestionItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    suggestionItem.style.opacity = '0';
                    suggestionItem.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        suggestionItem.remove();
                        checkEmptySuggestions();
                    }, 300);
                    
                    // Ajouter à la liste des invitations envoyées
                    addToSentInvitations(userId, userName, profilePic);
                    
                    showNotification(`Invitation envoyée à ${userName}`, 'success');
                }
            } catch (error) {
                console.error('Erreur envoi invitation:', error);
                this.disabled = false;
                this.textContent = 'Ajouter';
                showNotification('Erreur lors de l\'envoi', 'error');
            }
        });
    });

    
    // FONCTIONS UTILITAIRES
    function updateReceivedInvitationsCount() {
        const count = document.querySelectorAll('.invitation-received-item').length;
        const badge = document.getElementById('received-invitations-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }
    
    function updateSentInvitationsCount() {
        const count = document.querySelectorAll('.invitation-sent-item').length;
        const badge = document.getElementById('sent-invitations-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }
    
    function checkEmptyReceivedInvitations() {
        const list = document.getElementById('received-invitations-list');
        if (!list) return;
        
        const items = list.querySelectorAll('.invitation-received-item');
        
        if (items.length === 0) {
            list.innerHTML = '<div class="text-gray-600 italic text-sm text-center py-2">Aucune invitation reçue.</div>';
        }
    }
    
    function checkEmptySentInvitations() {
        const listContainer = document.getElementById('sent-invitations-list');
        if (!listContainer) return;
        
        const items = document.querySelectorAll('.invitation-sent-item');
        
        if (items.length === 0) {
            listContainer.innerHTML = '<div class="text-gray-600 italic text-sm text-center py-2">Aucune invitation envoyée pour l\'instant.</div>';
        }
    }
    
    function checkEmptySuggestions() {
        const suggestionsList = document.getElementById('suggestions-list');
        if (!suggestionsList) return;
        
        const items = document.querySelectorAll('.suggestion-item');
        
        if (items.length === 0) {
            suggestionsList.parentElement.innerHTML = '<div class="text-gray-600 italic text-sm text-center py-2">Aucune suggestion disponible.</div>';
        }
    }
    
    function addToSentInvitations(userId, userName, profilePic) {
        const listContainer = document.getElementById('sent-invitations-list');
        
        if (!listContainer) {
            console.error('Élément sent-invitations-list introuvable');
            return;
        }
        
        // Vérifier si invites-limited existe déjà
        let limited = document.getElementById('invites-limited');
        let full = document.getElementById('invites-full');
        
        if (!limited) {
            // La liste est vide, on doit créer la structure complète
            listContainer.innerHTML = `
                <div id="invites-limited"></div>
                <div id="invites-full" class="hidden"></div>
            `;
            limited = document.getElementById('invites-limited');
            full = document.getElementById('invites-full');
        }
        
        const inviteHTML = `
            <div class="invitation-sent-item flex flex-col gap-4 items-center justify-center bg-white rounded-2xl shadow-md p-4 mb-4 text-sm" data-receiver-id="${userId}" style="opacity: 0; transform: translateY(-10px);">
                <div class="flex gap-3 justify-center w-full">
                    <div class="flex gap-3 items-center justify-center">
                        <img class="w-10 h-10 object-cover rounded" src="profile-pic/${profilePic}" alt="">
                        <div class="break-words w-44">
                            Invitation envoyée à <strong>${userName}</strong>
                        </div>
                    </div>
                    <div class="text-gray-600 text-sm font-bold">À l'instant</div>
                </div>
                <button 
                    class="btn-cancel-invite flex items-center justify-center rounded-xl px-5 py-2 mt-1 text-sm w-full 
                    cursor-pointer outline-none font-medium text-white 
                    bg-gradient-to-r from-rose-500 to-red-400
                    shadow-md hover:shadow-lg transition-all 
                    hover:-translate-y-0.5 active:translate-y-0" 
                        data-receiver-id="${userId}" 
                        data-user-name="${userName}"
                        data-profile-pic="${profilePic}">
                    Annuler
                </button>
            </div>
        `;
        
        limited.insertAdjacentHTML('beforeend', inviteHTML);
        
        // Animation d'apparition
        setTimeout(() => {
            const newItem = limited.lastElementChild;
            if (newItem) {
                newItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                newItem.style.opacity = '1';
                newItem.style.transform = 'translateY(0)';
                
                // Réattacher l'événement d'annulation
                const cancelBtn = newItem.querySelector('.btn-cancel-invite');
                if (cancelBtn) {
                    cancelBtn.addEventListener('click', async function() {
                        const receiverId = this.dataset.receiverId;
                        const userName = this.dataset.userName;
                        const profilePic = this.dataset.profilePic;
                        const inviteItem = this.closest('.invitation-sent-item');
                        
                        const confirmed = await showModal(
                            'Annuler l\'invitation',
                            `Voulez-vous annuler l'invitation envoyée à ${userName} ?`,
                            'Annuler l\'invitation',
                            'Retour'
                        );
                        
                        if (!confirmed) return;
                        
                        try {
                            const response = await axios.post('actions/cancel-invitation.php', {
                                receiver_id: receiverId
                            });
                            
                            if (response.data.success) {
                                inviteItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                                inviteItem.style.opacity = '0';
                                inviteItem.style.transform = 'scale(0.9)';
                                
                                setTimeout(() => {
                                    inviteItem.remove();
                                    updateSentInvitationsCount();
                                    checkEmptySentInvitations();
                                    
                                    // Ajouter à la section suggestions
                                    addToSuggestions(receiverId, userName, profilePic);
                                }, 300);
                                
                                showNotification('Invitation annulée', 'info');
                            }
                        } catch (error) {
                            console.error('Erreur annulation invitation:', error);
                            showNotification('Erreur lors de l\'annulation', 'error');
                        }
                    });
                }
            }
        }, 10);
        
        updateSentInvitationsCount();
    }
    
    function addToSuggestions(userId, userName, profilePic) {
        // Chercher d'abord suggestions-list
        let suggestionsList = document.getElementById('suggestions-list');
        
        // Si suggestions-list n'existe pas, c'est que la liste est complètement vide
        // On doit recréer toute la structure
        if (!suggestionsList) {
            // Trouver le conteneur parent (celui avec "SUGGESTIONS D'AMIS")
            const allDivs = document.querySelectorAll('.flex.flex-col.justify-center');
            let parentContainer = null;
            
            for (let div of allDivs) {
                const title = div.querySelector('.text-gray-500.font-semibold');
                if (title && title.textContent.includes('SUGGESTIONS D\'AMIS')) {
                    parentContainer = div;
                    break;
                }
            }
            
            if (!parentContainer) {
                console.error('Impossible de trouver le conteneur SUGGESTIONS D\'AMIS');
                return;
            }
            
            // Créer la structure complète
            const emptyMsg = parentContainer.querySelector('.text-gray-600.italic');
            if (emptyMsg) {
                emptyMsg.remove();
            }
            
            parentContainer.insertAdjacentHTML('beforeend', `
                <div id="suggestions-list">
                    <div id="suggestion-limited"></div>
                    <div id="suggestion-full" class="hidden"></div>
                </div>
            `);
            
            suggestionsList = document.getElementById('suggestions-list');
        }
        
        // Maintenant on peut ajouter à suggestion-limited
        let limited = document.getElementById('suggestion-limited');
        
        if (!limited) {
            // Si suggestion-limited n'existe pas mais suggestions-list oui
            suggestionsList.innerHTML = `
                <div id="suggestion-limited"></div>
                <div id="suggestion-full" class="hidden"></div>
            `;
            limited = document.getElementById('suggestion-limited');
        }
        
        const suggestionHTML = `
            <div class="suggestion-item bg-white rounded-2xl shadow-md p-4 mb-4 text-sm" data-user-id="${userId}" style="opacity: 0; transform: translateY(-10px);">
                <div class="flex items-center gap-3">
                    <img class="w-13 h-13 object-cover rounded" src="profile-pic/${profilePic}" alt="">
                    <div class="flex gap-3 flex-col w-full">
                        <strong>${userName}</strong>
                        <button 
                            class="btn-add-friend w-full rounded-xl px-5 py-2 text-sm whitespace-nowrap cursor-pointer outline-none font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0" 
                            data-user-id="${userId}" 
                            data-user-name="${userName}"
                            data-profile-pic="${profilePic}">
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        limited.insertAdjacentHTML('beforeend', suggestionHTML);
        
        // Animation d'apparition
        setTimeout(() => {
            const newItem = limited.lastElementChild;
            if (newItem) {
                newItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                newItem.style.opacity = '1';
                newItem.style.transform = 'translateY(0)';
                
                // Réattacher l'événement d'ajout d'ami
                const addBtn = newItem.querySelector('.btn-add-friend');
                if (addBtn) {
                    addBtn.addEventListener('click', async function() {
                        const userId = this.dataset.userId;
                        const userName = this.dataset.userName;
                        const profilePic = this.dataset.profilePic;
                        const suggestionItem = this.closest('.suggestion-item');
                        
                        this.disabled = true;
                        this.textContent = 'Envoi...';
                        
                        try {
                            const response = await axios.post('actions/send-friend-request.php', {
                                receiver_id: userId
                            });
                            
                            if (response.data.success) {
                                suggestionItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                                suggestionItem.style.opacity = '0';
                                suggestionItem.style.transform = 'translateY(-10px)';
                                
                                setTimeout(() => {
                                    suggestionItem.remove();
                                    checkEmptySuggestions();
                                }, 300);
                                
                                addToSentInvitations(userId, userName, profilePic);
                                
                                showNotification(`Invitation envoyée à ${userName}`, 'success');
                            }
                        } catch (error) {
                            console.error('Erreur envoi invitation:', error);
                            this.disabled = false;
                            this.textContent = 'Ajouter';
                            showNotification('Erreur lors de l\'envoi', 'error');
                        }
                    });
                }
            }
        }, 10);
    }
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-[9998] ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            'bg-blue-500'
        }`;
        notification.textContent = message;
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        notification.style.transition = 'all 0.3s ease';
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // SYSTÈME DE MODAL
    function createModalContainer() {
        const modalHTML = `
            <div id="custom-modal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center">
                <div id="modal-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-md transition-opacity duration-300"></div>
                <div id="modal-content" class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
                    <h3 id="modal-title" class="text-xl font-bold text-gray-800 mb-3"></h3>
                    <p id="modal-message" class="text-gray-600 mb-6"></p>
                    <div class="flex gap-3 justify-end">
                        <button id="modal-cancel" class="px-5 py-2 rounded-xl text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors cursor-pointer outline-none">
                            Annuler
                        </button>
                        <button id="modal-confirm" class="px-5 py-2 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 hover:shadow-lg transition-all cursor-pointer outline-none">
                            Confirmer
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
    
    function showModal(title, message, confirmText = 'Confirmer', cancelText = 'Annuler') {
        return new Promise((resolve) => {
            const modal = document.getElementById('custom-modal');
            const modalContent = document.getElementById('modal-content');
            const backdrop = document.getElementById('modal-backdrop');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const confirmBtn = document.getElementById('modal-confirm');
            const cancelBtn = document.getElementById('modal-cancel');
            
            // Bloquer le scroll
            document.body.style.overflow = 'hidden';
            
            // Configurer le contenu
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            confirmBtn.textContent = confirmText;
            cancelBtn.textContent = cancelText;
            
            // Afficher le modal avec animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.style.opacity = '1';
                modalContent.style.opacity = '1';
                modalContent.style.transform = 'scale(1)';
            }, 10);
            
            // Gérer la confirmation
            const handleConfirm = () => {
                closeModal();
                resolve(true);
            };
            
            // Gérer l'annulation
            const handleCancel = () => {
                closeModal();
                resolve(false);
            };
            
            // Fonction pour fermer le modal
            const closeModal = () => {
                // Réactiver le scroll
                document.body.style.overflow = '';
                
                backdrop.style.opacity = '0';
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                
                // Retirer les événements
                confirmBtn.removeEventListener('click', handleConfirm);
                cancelBtn.removeEventListener('click', handleCancel);
                backdrop.removeEventListener('click', handleCancel);
            };
            
            // Attacher les événements
            confirmBtn.addEventListener('click', handleConfirm);
            cancelBtn.addEventListener('click', handleCancel);
            backdrop.addEventListener('click', handleCancel);
        });
    }
});