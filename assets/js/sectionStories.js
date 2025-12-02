let currentStoryIndex = 0;
let currentUserStories = [];
let storyProgressInterval = null;

// Charger les stories
async function loadStories() {
    try {
        const response = await axios.get('actions/get-stories.php');
        
        if (response.data.success) {
            displayStories(response.data.stories);
        }
    } catch (error) {
        console.error('Erreur chargement stories:', error);
    }
}

// Afficher les stories
function displayStories(stories) {
    const container = document.getElementById('stories-container');
    container.innerHTML = '';
    
    stories.forEach(userStories => {
        const hasUnviewed = userStories.stories.some(s => !s.viewed);
        const firstStory = userStories.stories[0];
        
        const div = document.createElement('div');
        div.className = 'relative cursor-pointer';
        div.style = 'flex: 0 0 auto; width: 135px; height: 210px';
        div.onclick = () => viewUserStories(userStories);
        
        // Déterminer le type de média
        const isVideo = firstStory.media_type === 'video';
        
        // Déterminer le contenu à afficher
        let contentHTML = '';
        
        if (firstStory.media && firstStory.text) {
            // Média + Texte 
            if (isVideo) {
                contentHTML = `
                    <div class="absolute inset-0 rounded-2xl ${hasUnviewed ? 'bg-gradient-to-br from-purple-600 via-pink-500 to-orange-500' : 'bg-gray-300'}">
                        <div class="w-full h-full bg-black rounded-2xl overflow-hidden relative">
                            <video class="w-full h-full object-cover" muted>
                                <source src="uploads/stories/${firstStory.media}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 bg-black/20"></div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white opacity-80" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                <p class="text-white text-xs font-medium line-clamp-2 opacity-85">${firstStory.text}</p>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                contentHTML = `
                    <div class="absolute inset-0 rounded-2xl ${hasUnviewed ? 'bg-gradient-to-br from-purple-600 via-pink-500 to-orange-500' : 'bg-gray-300'}">
                        <div class="w-full h-full bg-black rounded-2xl overflow-hidden relative">
                            <img class="w-full h-full object-cover" src="uploads/stories/${firstStory.media}" alt="">
                            <div class="absolute inset-x-0 bottom-3.5 bg-gradient-to-t from-black/80 to-transparent p-4">
                                <p class="text-white text-xs font-medium line-clamp-2 opacity-85">${firstStory.text}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        } else if (firstStory.media && !firstStory.text) {
            // Média seul
            if (isVideo) {
                contentHTML = `
                    <div class="absolute inset-0 rounded-2xl ${hasUnviewed ? 'bg-gradient-to-br from-purple-600 via-pink-500 to-orange-500' : 'bg-gray-300'}">
                        <div class="w-full h-full rounded-2xl overflow-hidden relative bg-black">
                            <video class="w-full h-full object-cover rounded-2xl" muted>
                                <source src="uploads/stories/${firstStory.media}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 bg-black/10"></div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white opacity-80" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                contentHTML = `
                    <div class="absolute inset-0 rounded-2xl ${hasUnviewed ? 'bg-gradient-to-br from-blue-400 via-[#06B6D4] to-purple-600' : 'bg-gray-300'}">
                        <img class="w-full h-full object-cover rounded-2xl" src="uploads/stories/${firstStory.media}" alt="">
                    </div>
                `;
            }
        } else if (!firstStory.media && firstStory.text) {
            // Texte seul
            contentHTML = `
                <div class="absolute inset-0 rounded-2xl ${hasUnviewed ? 'bg-gradient-to-br from-purple-600 via-pink-500 to-orange-500' : 'bg-gradient-to-br from-gray-400 to-gray-600'} p-[3px]">
                    <div class="w-full h-full bg-gradient-to-br from-purple-600 via-pink-500 to-orange-500 rounded-2xl flex items-center justify-center p-4">
                        <p class="text-white text-center text-sm font-bold drop-shadow-lg line-clamp-6">${firstStory.text}</p>
                    </div>
                </div>
            `;
        }
        
        div.innerHTML = contentHTML + `
            <img class="absolute w-9 h-9 rounded-xl top-3 left-3 object-cover ring-2 ring-white shadow-lg z-10" 
                 src="profile-pic/${userStories.user_pic}" alt="">
            <p class="absolute bottom-3 left-2 right-2 font-bold text-white text-sm drop-shadow-lg truncate z-10">
                ${userStories.user_name}
            </p>
        `;
        
        container.appendChild(div);
    });
}


// Voir les stories d'un utilisateur
function viewUserStories(userStories) {
    currentUserStories = userStories.stories;
    currentStoryIndex = 0;
    showStory();
    document.getElementById('view-story-modal').classList.remove('hidden');
}

function showStory() {
    const story = currentUserStories[currentStoryIndex];
    
    document.getElementById('story-user-pic').src = `profile-pic/${story.user_pic}`;
    document.getElementById('story-user-name').textContent = story.user_name;
    document.getElementById('story-time').textContent = story.time_ago;
    
    const imageEl = document.getElementById('story-view-image');
    const videoEl = document.getElementById('story-view-video');
    const textEl = document.getElementById('story-view-text');
    const textP = textEl.querySelector('p');
    
    // Déterminer le type de média
    const isVideo = story.media_type === 'video';
    
    // Réinitialiser tous les éléments
    imageEl.classList.add('hidden');
    videoEl.classList.add('hidden');
    textEl.classList.remove('inset-0', 'flex', 'items-center', 'justify-center');
    textEl.classList.add('bottom-20');
    textEl.style.background = '';
    textP.className = 'text-white text-center text-lg font-medium drop-shadow-lg';
    
    // Gérer les 3 cas d'affichage
    if (story.media && story.text) {
        // Média + Texte 
        if (isVideo) {
            videoEl.querySelector('source').src = `uploads/stories/${story.media}`;
            videoEl.load();
            videoEl.play();
            videoEl.classList.remove('hidden');
        } else {
            imageEl.src = `uploads/stories/${story.media}`;
            imageEl.classList.remove('hidden');
        }
        textP.textContent = story.text;
        textEl.classList.remove('hidden');
    } else if (story.media && !story.text) {
        // Média seul
        if (isVideo) {
            videoEl.querySelector('source').src = `uploads/stories/${story.media}`;
            videoEl.load();
            videoEl.play();
            videoEl.classList.remove('hidden');
        } else {
            imageEl.src = `uploads/stories/${story.media}`;
            imageEl.classList.remove('hidden');
        }
        textEl.classList.add('hidden');
    } else if (!story.media && story.text) {
        // Texte seul 
        textEl.classList.remove('hidden', 'bottom-20');
        textEl.classList.add('inset-0', 'flex', 'items-center', 'justify-center');
        textEl.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%)';
        textP.textContent = story.text;
        textP.className = 'text-white text-center text-3xl font-bold drop-shadow-2xl px-8 leading-relaxed';
    }
    
    startStoryProgress();
    markStoryAsViewed(story.id);
}

function startStoryProgress() {
    const progressBar = document.getElementById('story-progress-bar');
    let progress = 0;
    
    if (storyProgressInterval) clearInterval(storyProgressInterval);
    
    storyProgressInterval = setInterval(() => {
        progress += 1;
        progressBar.style.width = progress + '%';
        
        if (progress >= 100) {
            nextStory();
        }
    }, 50); 
}

function nextStory() {
    if (currentStoryIndex < currentUserStories.length - 1) {
        currentStoryIndex++;
        showStory();
    } else {
        closeViewStoryModal();
    }
}

function previousStory() {
    if (currentStoryIndex > 0) {
        currentStoryIndex--;
        showStory();
    }
}

function closeViewStoryModal() {
    if (storyProgressInterval) clearInterval(storyProgressInterval);
    
    // Arrêter la vidéo si elle joue
    const videoEl = document.getElementById('story-view-video');
    if (videoEl) {
        videoEl.pause();
        videoEl.currentTime = 0;
    }
    
    document.getElementById('view-story-modal').classList.add('hidden');
    loadStories(); // Recharger pour mettre à jour les vues
}

async function markStoryAsViewed(storyId) {
    try {
        await axios.post('../actions/mark-story-viewed.php', { story_id: storyId });
    } catch (error) {
        console.error('Erreur marquage vue:', error);
    }
}

// Charger au démarrage
document.addEventListener('DOMContentLoaded', () => {
    loadStories();
    setInterval(loadStories, 60000); 
});