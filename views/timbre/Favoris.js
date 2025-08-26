// Variables
const boutonHTML = document.querySelector("[data-bouton-enchere]");
const iconHTML = document.querySelector(".preference");

// Functions
// Function pour envoyer au backend les infos d'utilisateur et enchere
boutonHTML.addEventListener("click", async (e) => {
    const enchereId = e.currentTarget.dataset.enchere;
    const utilisateurId = e.currentTarget.dataset.utilisateur;

    try {
        const reponse = await fetch(`/STAMPEE/mvc/api/favoris/favoris?enchereId=${enchereId}&utilisateurId=${utilisateurId}`);

        if (!reponse.ok) {
            throw new Error("Erreur API");
        }

        // Recuperer le resultat du backend (si cest un favorit ou pas)
        const data = await reponse.json(); //
        console.log("Réponse API :", data);

        // Afficher une etoile s'il est favorite ou pas
        if (data['reponse'] == "non") {
            iconHTML.classList.add("inactive");
            console.log(iconHTML, "oui");
        } else {
            iconHTML.classList.remove("inactive");
            console.log(iconHTML, "non");
        }

    } catch (err) {
        console.error("Erreur fetch:", err);
    }
});

