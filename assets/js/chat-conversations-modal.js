const usersList = document.querySelector('.users-list');
const popupMessages = document.getElementById('popup-messages');
const chatContainer = document.getElementById('chat-container');
const chatPlace = document.querySelector('.chat-place');
const searchBar = document.querySelector('.searchBar');

let pollingInterval = null;
let lastMessageCount = 0;
let usersListPolling = null; 

// Charger la liste des conversations
async function fetchUsers() {
  try {
    const response = await axios.get("actions/conversations-modal-action.php");
    if(!searchBar.classList.contains('opacity-100')) {
        usersList.innerHTML = response.data;
    }
  } catch (error) {
    console.error("Erreur chargement conversations:", error);
  }
}

fetchUsers();

// Actualiser la liste toutes les 5 secondes
function startUsersListPolling() {
  if (usersListPolling) {
    clearInterval(usersListPolling);
  }
  
  usersListPolling = setInterval(async () => {
    // Ne pas actualiser si on est en train de chercher
    if (searchBar.classList.contains('opacity-100')) {
      return;
    }
    
    // Ne pas actualiser si on est dans une conversation
    if (!chatContainer.classList.contains('hidden')) {
      return;
    }
    
    try {
      const response = await axios.get("actions/conversations-modal-action.php");
      usersList.innerHTML = response.data;
    } catch (error) {
      console.error("Erreur actualisation liste:", error);
    }
  }, 5000); // Toutes les 5 secondes
}

// Démarrer l'actualisation de la liste
startUsersListPolling();


// Ouvrir dynamiquement une conversation
usersList.addEventListener('click', async (e) => {
  const userItem = e.target.closest('.user-item');
  if (!userItem) return;

  const contactId = userItem.dataset.userId;
  await openConversation(contactId);
});

async function openConversation(contactId) {
  try {
    const response = await axios.get('actions/get-chat-action.php', {
      params: { contact_id: contactId }
    });
    
    chatPlace.innerHTML = response.data;
    popupMessages.classList.add('hidden');
    chatContainer.classList.remove('hidden');
    
    initSendMessage(contactId);
    initBackButton();
    scrollToBottom();
    
    // Compter les messages actuels
    lastMessageCount = document.querySelectorAll('.message-item').length;
    
    // Démarrer la vérification des nouveaux messages
    startCheckingNewMessages(contactId);
    
  } catch (error) {
    console.error("Erreur ouverture conversation:", error);
  }
}

// Vérifier s'il y a de nouveaux messages
function startCheckingNewMessages(contactId) {
  // Arrêter l'ancien polling
  if (pollingInterval) {
    clearInterval(pollingInterval);
  }
  
  // Vérifier toutes les 2 secondes
  pollingInterval = setInterval(async () => {
    try {
      const response = await axios.get('actions/get-chat-action.php', {
        params: { contact_id: contactId }
      });
      
      // Parser le HTML pour compter les messages
      const parser = new DOMParser();
      const doc = parser.parseFromString(response.data, 'text/html');
      const newMessageCount = doc.querySelectorAll('.message-item').length;
      
      // S'il y a de nouveaux messages, recharger
      if (newMessageCount > lastMessageCount) {
        const messagesZone = document.getElementById('messages-zone');
        const wasAtBottom = messagesZone && 
          (messagesZone.scrollHeight - messagesZone.scrollTop - messagesZone.clientHeight < 100);
        
        chatPlace.innerHTML = response.data;
        lastMessageCount = newMessageCount;
        
        // Réinitialiser les écouteurs
        initSendMessage(contactId);
        initBackButton();
        
        // Scroll seulement si on était en bas
        if (wasAtBottom) {
          scrollToBottom();
        }
      }
      
    } catch (error) {
      console.error("Erreur vérification messages:", error);
    }
  }, 2000); // Toutes les 2 secondes
}


// Envoyer un message
function initSendMessage(contactId) {
  const sendBtn = document.getElementById('send-message-btn');
  const messageInput = document.getElementById('message-text');
  
  if (!sendBtn || !messageInput) return;

  const newSendBtn = sendBtn.cloneNode(true);
  sendBtn.parentNode.replaceChild(newSendBtn, sendBtn);
  
  newSendBtn.addEventListener('click', async () => {
    const message = messageInput.value.trim();
    if (!message) return;

    try {
        const response = await axios.post('actions/send-message-action.php', {
            receiver_id: contactId,
            message: message
        });

        if (response.data.success) {
            messageInput.value = '';
            await openConversation(contactId);
        }
    } catch (error) {
        console.error("Erreur envoi message:", error);
    }
  });

  messageInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      newSendBtn.click();
    }
  });
}


// Bouton retour
function initBackButton() {
  const backBtn = document.getElementById('back-to-list');
  if (!backBtn) return;
  
  const newBackBtn = backBtn.cloneNode(true);
  backBtn.parentNode.replaceChild(newBackBtn, backBtn);
  
  newBackBtn.addEventListener('click', () => {
    // Arrêter la vérification des messages
    if (pollingInterval) {
      clearInterval(pollingInterval);
    }
    
    chatContainer.classList.add('hidden');
    popupMessages.classList.remove('hidden');
    
    // Relancer l'actualisation de la liste
    startUsersListPolling();
  });
}

// Scroll automatique
function scrollToBottom() {
  setTimeout(() => {
    const messagesZone = document.getElementById('messages-zone');
    if (messagesZone) {
      messagesZone.scrollTo({
        top: messagesZone.scrollHeight,
        behavior: 'auto' 
      });
    }
  }, 100);
}

// Recherche avec actualisation
const loader = document.getElementById('loader');
let debounceTimer;
let searchPolling = null; 

searchBar.addEventListener('keyup', () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(runSearch, 300);
});

async function runSearch() {
  const searchInput = searchBar.value.trim();

  if (searchInput !== "") {
    searchBar.classList.remove('opacity-70');
    searchBar.classList.add('opacity-100');
  } else {
    searchBar.classList.remove('opacity-100');
    searchBar.classList.add('opacity-70');
    
    // Si la recherche est vide, arrêter le polling de recherche
    if (searchPolling) {
      clearInterval(searchPolling);
      searchPolling = null;
    }
    
    // Recharger la liste normale
    fetchUsers();
    startUsersListPolling();
    return;
  }

  loader.classList.remove('hidden');
  usersList.classList.add('opacity-50');

  try {
    const response = await axios.post(
      "actions/search_action.php",
      new URLSearchParams({ searchInput })
    );
    usersList.innerHTML = response.data;
    
    // Actualiser les résultats de recherche toutes les 5 secondes
    startSearchPolling(searchInput);
    
  } catch (error) {
    console.error("Erreur lors de la recherche :", error);
    usersList.innerHTML = `<p class="text-red-500 text-center mt-2">Une erreur est survenue.</p>`;
  } finally {
    loader.classList.add('hidden');
    usersList.classList.remove('opacity-50');
  }
}

// Actualiser les résultats de recherche
function startSearchPolling(searchTerm) {

  // Arrêter l'ancien polling de recherche
  if (searchPolling) {
    clearInterval(searchPolling);
  }
  
  // Arrêter le polling de la liste normale
  if (usersListPolling) {
    clearInterval(usersListPolling);
  }
  
  searchPolling = setInterval(async () => {
    // Vérifier si la recherche est toujours active
    const currentSearch = searchBar.value.trim();
    if (currentSearch !== searchTerm) {
      clearInterval(searchPolling);
      return;
    }
    
    // Ne pas actualiser si on est dans une conversation
    if (!chatContainer.classList.contains('hidden')) {
      return;
    }
    
    try {
      const response = await axios.post(
        "actions/search_action.php",
        new URLSearchParams({ searchInput: searchTerm })
      );
      usersList.innerHTML = response.data;
    } catch (error) {
      console.error("Erreur actualisation recherche:", error);
    }
  }, 5000);
}