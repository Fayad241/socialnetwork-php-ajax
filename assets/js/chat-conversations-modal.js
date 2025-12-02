// ========================================
// VARIABLES GLOBALES
// ========================================
const usersList = document.querySelector('.users-list');
const popupMessages = document.getElementById('popup-messages');
const chatContainer = document.getElementById('chat-container');
const chatPlace = document.querySelector('.chat-place');
const searchBar = document.querySelector('.searchBar');

let pollingInterval = null;
let lastMessageCount = 0;
let usersListPolling = null;
let currentContactId = null;
let conversationsPolling = null;

// Détecter si on est sur mobile ou desktop
const isMobile = () => window.innerWidth < 1024;

// ========================================
// FONCTIONS DESKTOP 
// ========================================

// Charger la liste des conversations (DESKTOP)
async function fetchUsers() {
  if (!usersList) return; 
  
  try {
    const response = await axios.get("actions/conversations-modal-action.php");
    if(!searchBar.classList.contains('opacity-100')) {
        usersList.innerHTML = response.data;
    }
  } catch (error) {
    console.error("Erreur chargement conversations:", error);
  }
}

if (!isMobile() && usersList) {
  fetchUsers();
}

// Actualiser la liste toutes les 5 secondes (DESKTOP)
function startUsersListPolling() {
  if (isMobile()) return; // Ne pas lancer sur mobile
  
  if (usersListPolling) {
    clearInterval(usersListPolling);
  }
  
  usersListPolling = setInterval(async () => {
    if (searchBar && searchBar.classList.contains('opacity-100')) {
      return;
    }
    
    if (chatContainer && !chatContainer.classList.contains('hidden')) {
      return;
    }
    
    try {
      const response = await axios.get("actions/conversations-modal-action.php");
      if (usersList) usersList.innerHTML = response.data;
    } catch (error) {
      console.error("Erreur actualisation liste:", error);
    }
  }, 5000);
}

if (!isMobile()) {
  startUsersListPolling();
}

// Ouvrir une conversation (DESKTOP)
if (usersList) {
  usersList.addEventListener('click', async (e) => {
    const userItem = e.target.closest('.user-item');
    if (!userItem) return;

    const contactId = userItem.dataset.userId;
    await openConversation(contactId);
  });
}

async function openConversation(contactId) {
  if (!chatPlace || !popupMessages || !chatContainer) return;
  
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
    
    lastMessageCount = document.querySelectorAll('.message-item').length;
    startCheckingNewMessages(contactId);
    
  } catch (error) {
    console.error("Erreur ouverture conversation:", error);
  }
}

// Vérifier nouveaux messages (DESKTOP)
function startCheckingNewMessages(contactId) {
  if (pollingInterval) {
    clearInterval(pollingInterval);
  }
  
  pollingInterval = setInterval(async () => {
    try {
      const response = await axios.get('actions/get-chat-action.php', {
        params: { contact_id: contactId }
      });
      
      const parser = new DOMParser();
      const doc = parser.parseFromString(response.data, 'text/html');
      const newMessageCount = doc.querySelectorAll('.message-item').length;
      
      if (newMessageCount > lastMessageCount) {
        const messagesZone = document.getElementById('messages-zone');
        const wasAtBottom = messagesZone && 
          (messagesZone.scrollHeight - messagesZone.scrollTop - messagesZone.clientHeight < 100);
        
        if (chatPlace) chatPlace.innerHTML = response.data;
        lastMessageCount = newMessageCount;
        
        initSendMessage(contactId);
        initBackButton();
        
        if (wasAtBottom) {
          scrollToBottom();
        }
      }
      
    } catch (error) {
      console.error("Erreur vérification messages:", error);
    }
  }, 2000);
}

// Envoyer un message (DESKTOP)
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

// Bouton retour (DESKTOP)
function initBackButton() {
  const backBtn = document.getElementById('back-to-list');
  if (!backBtn) return;
  
  const newBackBtn = backBtn.cloneNode(true);
  backBtn.parentNode.replaceChild(newBackBtn, backBtn);
  
  newBackBtn.addEventListener('click', () => {
    if (pollingInterval) {
      clearInterval(pollingInterval);
    }
    
    if (chatContainer) chatContainer.classList.add('hidden');
    if (popupMessages) popupMessages.classList.remove('hidden');
    
    startUsersListPolling();
  });
}

// Scroll (DESKTOP)
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

// Recherche (DESKTOP)
if (searchBar) {
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
      
      if (searchPolling) {
        clearInterval(searchPolling);
        searchPolling = null;
      }
      
      fetchUsers();
      startUsersListPolling();
      return;
    }

    if (loader) loader.classList.remove('hidden');
    if (usersList) usersList.classList.add('opacity-50');

    try {
      const response = await axios.post(
        "actions/search_action.php",
        new URLSearchParams({ searchInput })
      );
      if (usersList) usersList.innerHTML = response.data;
      
      startSearchPolling(searchInput);
      
    } catch (error) {
      console.error("Erreur lors de la recherche :", error);
      if (usersList) usersList.innerHTML = `<p class="text-red-500 text-center mt-2">Une erreur est survenue.</p>`;
    } finally {
      if (loader) loader.classList.add('hidden');
      if (usersList) usersList.classList.remove('opacity-50');
    }
  }

  function startSearchPolling(searchTerm) {
    if (searchPolling) {
      clearInterval(searchPolling);
    }
    
    if (usersListPolling) {
      clearInterval(usersListPolling);
    }
    
    searchPolling = setInterval(async () => {
      const currentSearch = searchBar.value.trim();
      if (currentSearch !== searchTerm) {
        clearInterval(searchPolling);
        return;
      }
      
      if (chatContainer && !chatContainer.classList.contains('hidden')) {
        return;
      }
      
      try {
        const response = await axios.post(
          "actions/search_action.php",
          new URLSearchParams({ searchInput: searchTerm })
        );
        if (usersList) usersList.innerHTML = response.data;
      } catch (error) {
        console.error("Erreur actualisation recherche:", error);
      }
    }, 5000);
  }
}

// ========================================
// FONCTIONS MOBILE
// ========================================
function openMobileConversations() {
    const conversationsView = document.getElementById('conversations-view');
    const chatView = document.getElementById('chat-view-mobile');

    if (chatView) chatView.classList.add('hidden');
    if (conversationsView) conversationsView.classList.remove('hidden');

    loadConversationsMobile();
}

// Charger les conversations (MOBILE)
async function loadConversationsMobile() {    
    const listContainer = document.getElementById('conversations-list-mobile');
    if (!listContainer) return;
    
    try {
        const response = await axios.get('actions/conversations-modal-action.php');
        const parser = new DOMParser();
        const doc = parser.parseFromString(response.data, 'text/html');
        
        const conversations = doc.querySelectorAll('.user-item');
        listContainer.innerHTML = '';
        
        if (conversations.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-12 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="font-medium">Aucun utilisateur disponible dans le chat</p>
                </div>
            `;
            return;
        }
        
        conversations.forEach(conv => {
            const userId = conv.dataset.userId;
            const userPic = conv.querySelector('img').src;
            const userName = conv.querySelector('strong').textContent;
            // const lastMessage = conv.querySelector('.text-gray-600')?.textContent || '';
            const lastMessage = conv.querySelector('.last-message')?.textContent || '';
            const date = conv.querySelector('.last-message-date')?.textContent || '';
            const notif = conv.querySelector('.user-notif') ? true : false;
            const statusDot = conv.querySelector('.bg-green-500, .bg-gray-400');
            const statusClass = statusDot ? statusDot.className : '';
            
            const convElement = document.createElement('div');
            convElement.className = 'flex items-center gap-3 p-4 hover:bg-gray-50 active:bg-gray-100 cursor-pointer border-b border-gray-100';
            convElement.onclick = () => openChatMobile(userId);
            
            convElement.innerHTML = `
                <div class="relative">
                    <img src="${userPic}" class="w-14 h-14 rounded-full object-cover" alt="">
                    <div class="${statusClass} absolute top-11 left-10 w-3.5 h-3.5 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-900 truncate">${userName}</h3>
                    <p class="text-sm text-gray-500 truncate">${lastMessage}</p>
                </div>

                <div class="flex gap-2 flex-col items-center">
                  <p class="text-xs text-gray-400">${date}</p>
                  ${notif ? '<div class="bg-blue-500 w-3 h-3 rounded-full animate-pulse"></div>' : ''}
                </div>
            `;
            
            listContainer.appendChild(convElement);
        });
        
        const loading = document.getElementById('loading-conversations');
        if (loading) loading.classList.add('hidden');
        
    } catch (error) {
        console.error('Erreur chargement conversations mobile:', error);
    }
}

// Ouvrir chat (MOBILE)
async function openChatMobile(contactId) {
    currentContactId = contactId;
    
    try {
        const response = await axios.get('actions/get-chat-action.php', {
            params: { contact_id: contactId }
        });
        
        const parser = new DOMParser();
        const doc = parser.parseFromString(response.data, 'text/html');
        
        // Header
        const userPic = doc.querySelector('img').src;
        const userName = doc.querySelector('strong').textContent;
        const statusText = doc.querySelectorAll('p')[0]?.textContent || '';
        const statusDot = doc.querySelector('.bg-green-500, .bg-gray-400');
        
        const chatUserPic = document.getElementById('chat-user-pic');
        const chatUserName = document.getElementById('chat-user-name');
        const chatUserStatusText = document.getElementById('chat-user-status-text');
        const chatUserStatus = document.getElementById('chat-user-status');
        
        if (chatUserPic) chatUserPic.src = userPic;
        if (chatUserName) chatUserName.textContent = userName;
        if (chatUserStatusText) chatUserStatusText.textContent = statusText;
        if (chatUserStatus && statusDot) {
            chatUserStatus.className = statusDot.className.replace('w-3', 'w-3.5').replace('h-3', 'h-3.5').replace('top-9', 'top-11');
        }
        
        // Messages
        const messagesZone = doc.getElementById('messages-zone');
        const messagesContainer = document.getElementById('messages-zone-mobile');
        if (messagesContainer) messagesContainer.innerHTML = '';
        
        const messages = messagesZone.querySelectorAll('.message-item');

        if (messages.length === 0) {
            messagesContainer.innerHTML = `
                <div class="text-center py-12 text-gray-500">
                    <p class="">Aucun message</p>
                </div>
            `;
            // return;
        }
        if (messagesZone && messagesContainer) {
            messages.forEach(msg => {
                const isSent = msg.classList.contains('ml-auto');
                const messageText = msg.querySelector('.flex.flex-col > div:first-child')?.textContent || '';
                const messageTime = msg.querySelector('.message-time')?.textContent || '';
                
                const msgElement = document.createElement('div');
                msgElement.className = isSent ? 'flex justify-end' : 'flex justify-start';
                
                if (isSent) {
                    msgElement.innerHTML = `
                        <div class="bg-blue-500 text-white rounded-2xl rounded-br-sm px-4 py-2 max-w-[75%]">
                            <p class="text-sm">${messageText}</p>
                            <p class="text-xs text-blue-100 text-right mt-1">${messageTime}</p>
                        </div>
                    `;
                } else {
                    msgElement.innerHTML = `
                    <div class="flex gap-3 bg-gray-100 text-gray-900 rounded-2xl rounded-bl-sm px-4 py-2 max-w-[75%]">
                        <img src="${userPic}" class="w-12 h-12 rounded-full object-cover" alt="">
                        <div class="flex gap-1 flex-col">
                            <p class="text-sm">${messageText}</p>
                            <p class="text-xs text-gray-500 text-left mt-1">${messageTime}</p>
                        </div>
                    </div>
                    `;
                }
                
                messagesContainer.appendChild(msgElement);
            });
        }
        
        // Changer de vue
        const conversationsView = document.getElementById('conversations-view');
        const chatView = document.getElementById('chat-view-mobile');
        if (conversationsView) conversationsView.classList.add('hidden');
        if (chatView) chatView.classList.remove('hidden');
        
        scrollToBottomMobile();
        startMessagePollingMobile(contactId);
        
    } catch (error) {
        console.error('Erreur ouverture chat mobile:', error);
    }
}

// Retour conversations (MOBILE)
function backToConversations() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
    
    const chatView = document.getElementById('chat-view-mobile');
    const conversationsView = document.getElementById('conversations-view');
    
    if (chatView) chatView.classList.add('hidden');
    if (conversationsView) conversationsView.classList.remove('hidden');
    
    currentContactId = null;
    
    loadConversationsMobile();
    startConversationsPollingMobile();
}

// Envoyer message (MOBILE)
const sendBtnMobile = document.getElementById('send-btn-mobile');
if (sendBtnMobile) {
    sendBtnMobile.addEventListener('click', async () => {
        const input = document.getElementById('message-input-mobile');
        if (!input) return;
        
        const message = input.value.trim();
        
        if (!message || !currentContactId) return;
        
        try {
            const response = await axios.post('actions/send-message-action.php', {
                receiver_id: currentContactId,
                message: message
            });
            
            if (response.data.success) {
                input.value = '';
                input.style.height = 'auto';
                await openChatMobile(currentContactId);
            }
        } catch (error) {
            console.error('Erreur envoi message mobile:', error);
        }
    });
}

// Auto-resize textarea (MOBILE)
const messageInputMobile = document.getElementById('message-input-mobile');
if (messageInputMobile) {
    messageInputMobile.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 128) + 'px';
    });
    
    messageInputMobile.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const btn = document.getElementById('send-btn-mobile');
            if (btn) btn.click();
        }
    });
}

// Scroll (MOBILE)
function scrollToBottomMobile() {
    setTimeout(() => {
        const zone = document.getElementById('messages-zone-mobile');
        if (zone) {
            zone.scrollTop = zone.scrollHeight;
        }
    }, 100);
}

// Polling messages (MOBILE)
function startMessagePollingMobile(contactId) {
    if (pollingInterval) clearInterval(pollingInterval);
    
    let lastMobileMessageCount = 0;
    
    pollingInterval = setInterval(async () => {
        if (currentContactId !== contactId) return;
        
        try {
            const response = await axios.get('actions/get-chat-action.php', {
                params: { contact_id: contactId }
            });
            
            const parser = new DOMParser();
            const doc = parser.parseFromString(response.data, 'text/html');
            const messagesZone = doc.getElementById('messages-zone');
            const newMessages = messagesZone.querySelectorAll('.message-item');
            
            // Vérifier s'il y a de nouveaux messages
            if (newMessages.length > lastMobileMessageCount) {
                const zone = document.getElementById('messages-zone-mobile');
                const wasAtBottom = zone && (zone.scrollHeight - zone.scrollTop - zone.clientHeight < 100);
                
                // Recharger uniquement si on était en bas
                if (wasAtBottom) {
                    await openChatMobile(contactId);
                    scrollToBottomMobile();
                } else {
                    // Sinon, juste mettre à jour le compteur sans recharger
                    lastMobileMessageCount = newMessages.length;
                }
            } else {
                lastMobileMessageCount = newMessages.length;
            }
            
        } catch (error) {
            console.error('Erreur polling mobile:', error);
        }
    }, 2000);
}


// Polling conversations (MOBILE)
function startConversationsPollingMobile() {
    if (conversationsPolling) clearInterval(conversationsPolling);
    
    conversationsPolling = setInterval(() => {
        const conversationsView = document.getElementById('conversations-view');
        const searchInput = document.getElementById('search-input-mobile');
        
        if (conversationsView && conversationsView.classList.contains('hidden')) return;
        
        if (searchInput && searchInput.value.trim() !== '') return;
        
        loadConversationsMobile();
    }, 5000);
}

// Recherche (MOBILE)
const searchInputMobile = document.getElementById('search-input-mobile');
if (searchInputMobile) {
    let searchTimeout;
    searchInputMobile.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(async () => {
            const query = e.target.value.trim();
            
            if (!query) {
                loadConversationsMobile();
                return;
            }
            
            try {
                const response = await axios.post('actions/search_action.php', 
                    new URLSearchParams({ searchInput: query })
                );
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(response.data, 'text/html');
                const results = doc.querySelectorAll('.user-item');
                
                const listContainer = document.getElementById('conversations-list-mobile');
                if (!listContainer) return;
                listContainer.innerHTML = '';

                if (results.length === 0) {
                  listContainer.innerHTML = `
                      <div class="text-center py-12 text-gray-500">
                          <p class="font-medium">Aucun utilisateur trouvé</p>
                      </div>
                  `;
                  return;
                }
                
                results.forEach(result => {
                    const userId = result.dataset.userId;
                    const userPic = result.querySelector('img').src;
                    const userName = result.querySelector('strong').textContent;
                    const lastMessage = result.querySelector('.last-message')?.textContent || '';
                    const date = result.querySelector('.last-message-date')?.textContent || '';
                    const notif = result.querySelector('.user-notif') ? true : false;
                    const statusDot = result.querySelector('.bg-green-500, .bg-gray-400');
                    const statusClass = statusDot ? statusDot.className : '';
                    
                    const element = document.createElement('div');
                    element.className = 'flex items-center gap-3 p-4 hover:bg-gray-50 cursor-pointer';
                    element.onclick = () => openChatMobile(userId);
                    element.innerHTML = `
                      <div class="relative">
                          <img src="${userPic}" class="w-14 h-14 rounded-full object-cover" alt="">
                          <div class="${statusClass} absolute top-11 left-10 w-3.5 h-3.5 rounded-full border-2 border-white"></div>
                      </div>
                      <div class="flex-1 min-w-0">
                          <h3 class="font-bold text-gray-900 truncate">${userName}</h3>
                          <p class="text-sm text-gray-500 truncate">${lastMessage}</p>
                      </div>

                      <div class="flex gap-2 flex-col items-center">
                        <p class="text-xs text-gray-400">${date}</p>
                        ${notif ? '<div class="bg-blue-500 w-3 h-3 rounded-full animate-pulse"></div>' : ''}
                      </div>
                    `;
                    listContainer.appendChild(element);
                  });
                
            } catch (error) {
                console.error('Erreur recherche mobile:', error);
            }
        }, 300);
    });
}

// INITIALISATION
if (isMobile()) {
    loadConversationsMobile();
    startConversationsPollingMobile();
}