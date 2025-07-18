// // Attendre que le DOM soit complètement chargé
// function initMessageSending() {
//     const sendButton = document.getElementById('send-message-btn');
    
//     if (!sendButton) {
//         console.error("Bouton non trouvé - Réessayez dans 500ms");
//         setTimeout(initMessageSending, 500);
//         return;
//     }

//     sendButton.addEventListener('click', async function() {
//         e.preventDefault();
        
//         const senderId = document.getElementById('sender-id')?.value.trim();
//         const receiverId = document.getElementById('receiver-id')?.value.trim();
//         const message = document.getElementById('message-text')?.value.trim();

//         // Validation
//         if (!receiverId) {
//             alert("Aucun destinataire sélectionné !");
//             return;
//         }

//         if (!message) {
//             alert("Veuillez écrire un message");
//             return;
//         }

//         try {
//             // Feedback visuel
//             sendButton.disabled = true;
//             sendButton.innerHTML = '<span>Envoi...</span>';

//             const response = await axios.post('actions/send-message-action.php', {
//                 sender_id: senderId,
//                 receiver_id: receiverId,
//                 message: message
//             });

//             if (response.data.success) {
//                 document.getElementById('message-text').value = '';
//                 // Ajout dynamique du message
//                 addNewMessage(message, true);
//             }
//         } catch (error) {
//             console.error("Erreur:", error);
//             alert("Échec de l'envoi");
//         } finally {
//             sendButton.disabled = false;
//             sendButton.innerHTML = '<svg>...</svg>'; // Remettre l'icône
//         }
//     });
// }

// // Lancement initial
// document.addEventListener('DOMContentLoaded', initMessageSending);
// // Re-tentative si chargement dynamique
// initMessageSending();