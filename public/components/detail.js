export const ArticleDetail = {
    // Les props sont les données reçues depuis ton HTML (ton PHP)
    props: ['id', 'title'],

    data() {
        return {
            details: null,      // Sera null tant qu'on n'a pas fetch
            isLoading: false
        };
    },

    // Le template contient ta structure HTML + l'affichage dynamique
    template: `
        <div class="article-box" @mouseover="fetchDetails">
            <h3>{{ title }}</h3>
            
            <div v-if="isLoading">Chargement des détails...</div>
            
            <div v-if="details" class="details-box">
                <p><strong>Date de création :</strong> {{ details.date_creation }}</p>
                <p><strong>Durée :</strong> {{ details.duree_lecture }} min</p>
                <p><strong>Catégorie :</strong> {{ details.categorie }}</p>
            </div>
            
            <p v-else-if="!isLoading">Survolez pour voir les détails...</p>
        </div>
    `,

    methods: {
        async fetchDetails() {
            // Si on a déjà les détails, on ne fait rien pour ne pas surcharger le serveur
            if (this.details) return;

            this.isLoading = true;

            try {
                // Appel vers ton routeur PHP
                const response = await fetch('index.php?page=api_detail_fetch&id=' + this.id);

                // Conversion en JSON
                const data = await response.json();

                // Mise à jour de l'état
                this.details = data;
            } catch (error) {
                console.error("Erreur Fetch:", error);
            } finally {
                this.isLoading = false;
            }
        }
    }
};