document.getElementById('logoutBtn').addEventListener('click', async () => {
    try {
        const response = await axios.post('actions/logout.php');
        
        if (response.data.success) {
            sessionStorage.clear(); 
            window.location.href = 'vues/clients/login.php';
        } else {
            alert('Erreur lors de la déconnexion');
        }
    } catch (err) {
        console.error("Erreur :", err);
    }
});
