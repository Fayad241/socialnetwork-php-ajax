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