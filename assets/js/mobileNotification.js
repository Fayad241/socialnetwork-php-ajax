// Charger les notifications
async function loadNotifications() {
    const loader = document.getElementById('loader');
    const container = document.getElementById('notifications-container');
    const emptyMsg = document.getElementById('empty-notifications');
    const countText = document.getElementById('notif-count');
    
    try {
        const response = await axios.get('/socialnetwork/actions/get-notifications.php');
        
        if (response.data.success) {
            const notifications = response.data.notifications;
            const unreadCount = response.data.unread_count;
            
            // Mettre à jour le compteur
            countText.textContent = unreadCount > 0 
                ? `${unreadCount} notifications${unreadCount > 1 ? 's' : ''}`
                : 'Aucune nouvelle notification';
            
            displayNotifications(notifications);
        }
    } catch (error) {
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4">
                <svg class="w-16 h-16 text-red-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600 text-center">Impossible de charger les notifications</p>
                <button onclick="loadNotifications()" class="mt-4 text-blue-600 font-medium">Réessayer</button>
            </div>
        `;
    } finally {
        loader.classList.add('hidden');
    }
}

// Afficher les notifications
function displayNotifications(notifications) {
    const container = document.getElementById('notifications-container');
    const emptyMsg = document.getElementById('empty-notifications');
    
    container.innerHTML = '';
    
    if (!notifications || notifications.length === 0) {
        emptyMsg.classList.remove('hidden');
        return;
    }
    
    emptyMsg.classList.add('hidden');
    
    notifications.forEach((notif, index) => {
        const div = document.createElement('div');
        div.className = 'flex gap-4 p-4 border-b border-gray-100 active:bg-gray-50 transition-colors';
        
        if (!notif.is_read) {
            div.classList.add('bg-blue-50');
        }
        
        // Badge selon le type
        let badge = '';
        if (notif.type === 'friend-accepted') {
            badge = '<div class="absolute -bottom-0.5 -right-0.5 bg-green-500 rounded-full p-1 ring-2 ring-white"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></div>';
        } else if (notif.type === 'like') {
            badge = '<div class="absolute -bottom-0.5 -right-0.5 bg-red-500 rounded-full p-1 ring-2 ring-white"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>';
        } else if (notif.type === 'comment') {
            badge = '<div class="absolute -bottom-0.5 -right-0.5 bg-blue-500 rounded-full p-1 ring-2 ring-white"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg></div>';
        } else if (notif.type === 'favorite') {
            badge = '<div class="absolute -bottom-0.5 -right-0.5 bg-yellow-500 rounded-full p-1 ring-2 ring-white"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div>';
        }
        
        div.innerHTML = `
            <div class="relative flex-shrink-0">
                <img class="w-14 h-14 object-cover rounded-full ${notif.type === 'friend-request' ? 'ring-2 ring-blue-500' : ''}" 
                        src="/socialnetwork/profile-pic/${notif.sender_pic}" 
                        alt="${notif.sender_name}">
                ${badge}
            </div>
            
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <p class="text-sm text-gray-800 leading-relaxed">
                        <span class="font-semibold text-gray-900">${notif.sender_name}</span>
                        <span class="text-gray-700"> ${notif.message}</span>
                    </p>
                    ${!notif.is_read ? '<div class="w-2 h-2 bg-blue-600 rounded-full flex-shrink-0 mt-1.5"></div>' : ''}
                </div>
                
                <p class="text-xs text-gray-500 mb-2">${notif.time_ago}</p>
                
                ${notif.type === 'friend-request' ? `
                    <div class="flex gap-2 mt-3">
                        <button onclick="acceptFriend(${notif.sender_id}, ${notif.id})" 
                                class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg px-4 py-2.5 text-sm font-medium hover:shadow-md active:scale-95 transition-all">
                            Accepter
                        </button>
                        <button onclick="rejectFriend(${notif.sender_id}, ${notif.id})" 
                                class="flex-1 border-2 border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-gray-50 active:scale-95 transition-all">
                            Refuser
                        </button>
                    </div>
                ` : ''}
            </div>
        `;
        
        container.appendChild(div);
    });
}

// Accepter une invitation
async function acceptFriend(senderId, notifId) {
    try {
        const response = await axios.post('/socialnetwork/actions/accept-invitation.php', {
            sender_id: senderId
        });
        
        if (response.data.success) {
            loadNotifications();
        }
    } catch (error) {
        // console.error('Erreur:', error);
    }
}

// Refuser une invitation
async function rejectFriend(senderId, notifId) {
    try {
        const response = await axios.post('/socialnetwork/actions/reject-invitation.php', {
            sender_id: senderId
        });
        
        if (response.data.success) {
            loadNotifications();
        }
    } catch (error) {
        // console.error('Erreur:', error);
    }
}

// Marquer toutes comme lues
async function markAllAsRead() {
    try {
        const response = await axios.post('/socialnetwork/actions/mark-all-notifications-read.php');
        
        if (response.data.success) {
            loadNotifications();
        }
    } catch (error) {
        // console.error('Erreur:', error);
    }
}

// Charger au démarrage
document.addEventListener('DOMContentLoaded', () => {
    loadNotifications();
    setInterval(loadNotifications, 30000);
});