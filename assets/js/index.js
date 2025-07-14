const openNotification = document.getElementById('open-notifications');
const closeNotification = document.getElementById('close-notifications');
const popupNotification = document.getElementById('popup-notifications');

openNotification.addEventListener('click', () => {
    popupNotification.style.display = 'block';
})

closeNotification.addEventListener('click', () => {
    popupNotification.style.display = 'none';
})

const openMessage = document.getElementById('open-messages');
const closeMessage = document.getElementById('close-messages');
const popupMessage = document.getElementById('popup-messages');

openMessage.addEventListener('click', () => {
    popupMessage.style.display = 'block';
})

closeMessage.addEventListener('click', () => {
    popupMessage.style.display = 'none';
})


document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('toggle-suggestions');
    const limited = document.getElementById('suggestion-limited');
    const full = document.getElementById('suggestion-full');

    let expanded = false;

    btn.addEventListener('click', () => {
      expanded = !expanded;

      if (expanded) {
        limited.classList.add('hidden');
        full.classList.remove('hidden');
        btn.textContent = "Voir moins";
      } else {
        full.classList.add('hidden');
        limited.classList.remove('hidden');
        btn.textContent = "Voir plus";
      }
    });
});







