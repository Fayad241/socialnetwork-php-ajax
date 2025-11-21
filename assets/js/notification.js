// Ouvrir et fermer les notifications
const openNotification = document.getElementById('open-notifications');
const closeNotification = document.getElementById('close-notifications');
const popupNotification = document.getElementById('popup-notifications');

openNotification.addEventListener('click', () => {
    popupNotification.style.display = 'block';
})

closeNotification.addEventListener('click', () => {
    popupNotification.style.display = 'none';
})


// Charger les notifications
async function loadNotifications() {
  try {
    const response = await axios.get('actions/get-notifications.php');
    console.log('Réponse notifications:', response.data);
    
    if (response.data.success) {
      displayNotifications(response.data.notifications);
      updateBadge(response.data.unread_count);
    }
  } catch (error) {
    console.error('Erreur:', error);
  }
}

// Afficher les notifications
function displayNotifications(notifications) {
  const container = document.getElementById('notifications-container');
  const emptyMsg = document.getElementById('empty-notifications');
  
  // Vider le conteneur
  container.innerHTML = '';
  
  // Si pas de notifications
  if (!notifications || notifications.length === 0) {
    emptyMsg.classList.remove('hidden');
    return;
  }
  
  emptyMsg.classList.add('hidden');
  
  // Créer chaque notification
  notifications.forEach(notif => {
    const div = document.createElement('div');
    div.className = 'flex gap-3 py-3 px-4 border-b border-gray-100 hover:bg-gray-50 transition-colors';
    
    // Fond bleu si non lu
    if (!notif.is_read) {
      div.classList.add('bg-blue-50');
    }
    
    // Icône avec badge selon le type
    let badge = '';
    if (notif.type === 'friend-accepted') {
      badge = '<div class="absolute -bottom-1 -right-1 bg-green-500 rounded-full p-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></div>';
    } else if (notif.type === 'like') {
      badge = '<div class="absolute -bottom-1 -right-1 bg-red-500 rounded-full p-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>';
    } else if (notif.type === 'comment') {
      badge = '<div class="absolute -bottom-1 -right-1 bg-blue-500 rounded-full p-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg></div>';
    } else if (notif.type === 'favorite') {
      badge = '<div class="absolute bottom-2 -right-1 bg-yellow-500 rounded-full p-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div>';
    }
    
    div.innerHTML = `
      <div class="relative">
        <img class="w-12 h-12 object-cover rounded-full ${notif.type === 'friend-request' ? 'ring-2 ring-blue-500' : ''}" src="profile-pic/${notif.sender_pic}" alt="">
        ${badge}
      </div>
      <div class="flex flex-col gap-1 flex-1">
        <div class="text-gray-700 text-sm">
          <strong class="text-gray-900 font-semibold">${notif.sender_name}</strong> ${notif.message}
        </div>
        <div class="text-gray-500 text-xs">${notif.time_ago}</div>
        ${notif.type === 'friend-request' ? `
          <div class="flex gap-2 mt-2">
            <button onclick="acceptFriend(${notif.sender_id}, ${notif.id})" 
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg px-4 py-2 text-sm font-medium hover:shadow-lg transition-all">
              Accepter
            </button>
            <button onclick="rejectFriend(${notif.sender_id}, ${notif.id})" 
                    class="flex-1 border border-gray-300 text-gray-700 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition-all">
              Refuser
            </button>
          </div>
        ` : ''}
      </div>
    `;
    
    // Clic pour aller au post(sauf pour friend-request)
    // if (notif.type !== 'friend-request' && notif.post_id) {
    //   div.classList.add('cursor-pointer');
    //   div.onclick = () => {
    //     markAsRead(notif.id);
    //     window.location.href = `post.php?id=${notif.post_id}`;
    //   };
    // }
    
    container.appendChild(div);
  });
}

// Mettre à jour le badge
function updateBadge(count) {
  const badges = document.querySelectorAll('.notif-badge');
  
  badges.forEach(badge => {
    if (count > 0) {
      badge.textContent = count > 99 ? '99+' : count;
      badge.classList.remove('hidden');
    } else {
      badge.classList.add('hidden');
    }
  });
}

// Accepter une invitation
// async function acceptFriend(senderId, notifId) {
//   try {
//     const response = await axios.post('actions/accept-invitation.php', {
//       sender_id: senderId
//     });
    
//     if (response.data.success) {
//       loadNotifications(); 
//     }
//   } catch (error) {
//     console.error('Erreur:', error);
//   }
// }

// Refuser une invitation
// async function rejectFriend(senderId, notifId) {
//   try {
//     const response = await axios.post('actions/reject-invitation.php', {
//       sender_id: senderId
//     });
    
//     if (response.data.success) {
//       loadNotifications(); 
//     }
//   } catch (error) {
//     console.error('Erreur:', error);
//   }
// }

// Marquer comme lu
// async function markAsRead(notifId) {
//   try {
//     await axios.post('actions/mark-notification-read.php', {
//       notification_id: notifId
//     });
//   } catch (error) {
//     console.error('Erreur:', error);
//   }
// }

// Charger au démarrage et toutes les 10 secondes
document.addEventListener('DOMContentLoaded', () => {
  loadNotifications();
  setInterval(loadNotifications, 10000);
});