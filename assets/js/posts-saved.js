async function loadSavedPosts() {
    const container = document.getElementById("saved-posts-container");
    const userId = container.dataset.authorId;

    try {
        const response = await axios.get('../../actions/get-saved-posts.php', {
            params: { user_id: userId }
        });

        if (!response.data.success) {
            container.innerHTML = `
                <div class="text-red-500">Impossible de charger les posts</div>
            `;
            return;
        }

        const posts = response.data.posts;
        let totalSaved = response.data.totalSaved;

        container.innerHTML = `
            <div id="total-saved-count" class="text-gray-900 font-medium">
                Total posts enregistrés : ${totalSaved}
            </div>
            ${posts.length
                ? posts.map(post => displaySavedPost(post)).join('')
                : `<p class="text-center text-gray-500 py-10">Aucun post enregistré.</p>`}
        `;

        // Initialiser la gestion du retrait des favoris
        initRemoveFavorite();

    } catch (error) {
        console.error(error);
        container.innerHTML = `
            <div class="text-red-500 text-center py-10">
                Erreur de chargement
            </div>
        `;
    }
}

function displaySavedPost(post) {
    return `
        <div class="flex flex-col justify-center bg-white rounded-2xl shadow-md px-5 py-4 mb-5">

            <div class="flex items-center gap-3 mb-3">
                <img class="w-10 h-10 rounded object-cover"
                    src="/socialnetwork/profile-pic/${post["profile-pic"]}"
                    alt=""
                >
                    
                <div>
                    <div class="font-bold">
                        ${post["last-name"]} ${post["first-name"]}
                    </div>

                    <div class="text-gray-400">
                        ${post.timeAgo}
                    </div>
                </div>
            </div>

            <div class="my-4">
                ${post.content.replace(/\n/g, "<br>")}
            </div>

            ${post["img-publication"] ? `
                <img 
                    src="/socialnetwork/uploads/posts/${post["img-publication"]}"
                    class="h-[90vh] w-full rounded-xl object-cover"
                />
            ` : ""}

            <div class="mt-3 flex gap-4">
                <button 
                    class="px-4 py-2 ml-auto rounded-lg text-red-500 underline text-sm hover:text-red-400 cursor-pointer outline-none
                        relative overflow-hidden remove-save"
                    data-id="${post.id}"
                >
                    Retirer des favoris
                </button>
            </div>

        </div>
    `;
}

// Fonction pour gérer le retrait d’un favori
function initRemoveFavorite() {
    document.querySelectorAll(".remove-save").forEach(button => {
        button.addEventListener("click", async (e) => {
            const postDiv = button.closest(".flex.flex-col");
            const postId = button.dataset.id;

            try {
                const res = await axios.post('../../actions/remove-favorite.php', { post_id: postId });

                if (res.data.success) {
                    
                    setTimeout(() => {
                        postDiv.remove();
                    }, 1000);

                    // Mettre à jour le compteur
                    const totalSavedEl = document.getElementById("total-saved-count");
                    if (totalSavedEl) {
                        totalSavedEl.innerText = `Total posts enregistrés : ${res.data.totalSaved}`;
                    }
                } else {
                    alert(res.data.message || "Impossible de retirer le post.");
                }

            } catch (err) {
                console.error(err);
                alert("Erreur lors du retrait du favori.");
            }
        });
    });
}

// Charger les posts au démarrage
loadSavedPosts();
