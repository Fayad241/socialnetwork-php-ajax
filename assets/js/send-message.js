// Définir l'ID du destinataire
let currentReceiverId = null;

function setReceiverId(userId) {
    currentReceiverId = userId;
    document.getElementById('receiver-id').value = userId;
}

// Envoi du formulaire via Axios
document.getElementById('message-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const senderId = document.getElementById('sender-id').value;
    const receiverId = document.getElementById('receiver-id').value;
    const message = document.getElementById('message-text').value;

    if (!receiverId) {
        alert("Aucun destinataire sélectionné !");
        return;
    }

    try {
        const response = await axios.post('actions/send-message.php', {
            sender_id: senderId,
            receiver_id: receiverId,
            message: message
        });

        if (response.data.success) {
            document.getElementById('message-text').value = ''; // Vide le textarea
            loadConversation(receiverId); // Recharge les messages
        } else {
            console.error("Erreur :", response.data.error);
        }
    } catch (error) {
        console.error("Erreur réseau :", error);
    }
});