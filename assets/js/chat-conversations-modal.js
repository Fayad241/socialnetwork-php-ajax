let usersList = document.querySelector('.users-list');

if(usersList) {
    console.log("liste d'utilisateurs present")
}

async function fetchUsers() {
  try {
    const response = await axios.get("actions/conversations-modal-action.php");
    // if(!searchBar.classList.contains('active')) {
      usersList.innerHTML = response.data;
    // }
  } catch (error) {
    console.error("Erreur lors de la récupération des utilisateurs :", error);
  }
}

fetchUsers();


// Clics sur les utilisateurs
usersList.addEventListener('click', async (e) => {
    const userItem = e.target.closest('.user-item');
    if (!userItem) return;

    const userId = userItem.dataset.userId;
    console.log(userId)
    await loadConversation(userId);
});

// Charge la conversation
async function loadConversation(userId) {
    try {
        // 1. Charger les messages existants
        const response = await axios.get(`actions/get-chat-action.php`, {
            params: { contact_id: userId }
        });
        
        document.querySelector('.chat-place').innerHTML = response.data;

        // 2. Gestion de l'affichage
        document.getElementById('popup-messages').classList.add('hidden');
        const chatContainer = document.getElementById('chat-container');
        chatContainer.classList.remove('hidden');
        chatContainer.classList.add('flex');

        // 3. Initialiser l'écouteur d'envoi
        setupMessageSending(userId);

        // 4. Bouton retour
        document.getElementById('back-to-list').addEventListener('click', () => {
            chatContainer.classList.add('hidden');
            document.getElementById('popup-messages').classList.remove('hidden');
        });

    } catch (error) {
        console.error("Erreur:", error);
    }
}

function setupMessageSending(userId) {
    // Correction ici : Sélectionnez le bouton par son ID
    const sendButton = document.getElementById('send-message-btn');
    const messageInput = document.getElementById('message-text');
    
    console.log("Bouton sélectionné:", sendButton);
    console.log("Champ message:", messageInput);

    if (!sendButton || !messageInput) {
        console.error("Éléments introuvables");
        return;
    }

    // Ajout de l'écouteur sur le bouton
    sendButton.addEventListener('click', async (e) => {
        e.preventDefault();
        
        const senderId = document.getElementById('sender-id')?.value.trim();
        const message = messageInput.value.trim();

        console.log("Tentative d'envoi:", {senderId, userId, message});

        if (!message) {
            alert("Veuillez écrire un message");
            return;
        }

        try {
            // Feedback visuel
            // sendButton.disabled = true;
            // const originalText = sendButton.innerHTML;
            // sendButton.innerHTML = 'Envoi en cours...';

            const response = await axios.post('actions/send-message-action.php', {
                sender_id: senderId,
                receiver_id: userId, // Utilisation cohérente du paramètre
                message: message
            });

            if (response.data.success) {
                messageInput.value = '';
                // Option 1: Rechargement complet
                await loadConversation(userId);
                
                // Option 2: Ajout dynamique (plus fluide)
                // addNewMessage(message, true, userId);
            }
        } catch (error) {
            console.error("Erreur complète:", error);
            alert("Échec de l'envoi: " + (error.response?.data?.error || error.message));
        } 
    });
}

// Fonction pour l'option d'ajout dynamique
function addNewMessage(content, isSent, userId) {
    const container = document.querySelector('.chat-place');
    const messageClass = isSent ? 'sent' : 'received';
    
    const messageHTML = `
        <div class="message ${messageClass}">
            <div>${content}</div>
            <div class="time">${new Date().toLocaleTimeString()}</div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', messageHTML);
    container.scrollTop = container.scrollHeight;
}