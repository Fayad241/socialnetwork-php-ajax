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
    // Gestion d'erreur personnalisée ici
  }
}

fetchUsers();


// Écoute les clics sur les utilisateurs
document.addEventListener('DOMContentLoaded', () => {
    const userList = document.querySelector('.users-list');
    
    userList.addEventListener('click', async (e) => {
        console.log("utilisateur cliqué")
        const userItem = e.target.closest('.user-item');
        console.log(userItem)
        if (!userItem) return;

        const userId = userItem.dataset.userId;
        console.log(userId)
        await loadConversation(userId);
    });
});

// Charge la conversation
async function loadConversation(userId) {
    try {
        const response = await axios.get(`actions/get-chat-action.php?contact_id=${userId}`);
        document.getElementById('chat-container').innerHTML = response.data;

        console.log("Réponse reçue:", response.data);
        
        document.getElementById('popup-messages').classList.add('hidden');

        // Affiche le modal du chat
        document.getElementById('chat-container').classList.remove('hidden');
        document.getElementById('chat-container').classList.add('flex');
        console.log("load conversation succeed")
    } catch (error) {
        console.error("Erreur:", error);
    }
}