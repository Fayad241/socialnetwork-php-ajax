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
// const userList = document.querySelector('.users-list');

usersList.addEventListener('click', async (e) => {
    console.log("utilisateur cliqué")
    const userItem = e.target.closest('.user-item');
    console.log(userItem)
    if (!userItem) return;

    // document.querySelectorAll('.user-item').forEach(item => {
    //     item.classList.remove('bg-blue-50');
    // });
    // userItem.classList.add('bg-blue-50');

    const userId = userItem.dataset.userId;
    console.log(userId)
    await loadConversation(userId);
});

// Charge la conversation
async function loadConversation(userId) {
    try {

        const response = await axios.get(`actions/get-chat-action.php?contact_id=${userId}`);

        // const response = await axios.get(`actions/get-chat-action.php`, {
        //     params: {
        //         contact_id: userId // Plus propre que dans l'URL
        //     }
        // });
        document.querySelector('.chat-place').innerHTML = response.data;

        console.log("Réponse reçue:", response.data);
        
        document.getElementById('popup-messages').classList.add('hidden');

        // Affiche le modal du chat
        document.getElementById('chat-container').classList.remove('hidden');
        document.getElementById('chat-container').classList.add('flex');
        
        console.log(document.getElementById('chat-container'));
        console.log(document.querySelector('.chat-place'));
        console.log(document.getElementById('popup-messages'));
        console.log("load conversation succeed")
    } catch (error) {
        console.error("Erreur:", error);
    }
}