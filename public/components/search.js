export const SearchComponent = {
    // Les données initiales (reporters et max) viennent de window (injectées par PHP)
    data() {
        return {
            keyword: '',
            author: '',
            limit: window.MAX_VAL || 10,
            reporters: window.REPORTERS || [],
            results: [],
            isLoading: false,
            erreur_message: null
        };
    },

    template: `
    <div class="search-page-layout">
        <aside class="menu-lateral">
            <h3>Filtres de recherche</h3>
            
            <div class="field">
                <label>Mot-clé :</label>
                <input type="text" v-model="keyword" @input="performSearch" placeholder="Ex: France...">
            </div>

            <div class="field">
                <label>Auteur :</label>
                <select v-model="author" @change="performSearch">
                    <option value="">Tous les auteurs</option>
                    <option v-for="rep in reporters" :key="rep.name" :value="rep.name">
                        {{ rep.name }}
                    </option>
                </select>
            </div>

            <div class="field">
                <label>Résultats max :</label>
                <input type="number" v-model="limit" @input="performSearch" min="1" :max="100">
            </div>
        </aside>

        <main class="result-column">
            <h2>Articles trouvés ({{ results.length }})</h2>

            <div v-if="isLoading">Recherche en cours...</div>
            <div v-if="erreur_message" style="color:red;">{{ erreur_message }}</div>
            
            <ul v-if="!isLoading && results.length > 0" class="result-list">
                <li v-for="art in results" :key="art.ident_art || art.id">
                    <a :href="'?page=article&ident_art=' + (art.ident_art || art.id)">
                        {{ art.title_art || art.title || 'Sans titre' }}
                    </a>
                </li>
            </ul>

            <p v-else-if="!isLoading && keyword.length >= 2">
                Aucun article ne correspond à votre recherche.
            </p>
        </main>
    </div>
    `,

    methods: {
        performSearch() {
            // Optionnel : ne pas chercher si le mot-clé est trop court
            if (this.keyword.length > 0 && this.keyword.length < 2) return;

            this.isLoading = true;
            this.erreur_message = null;

            // 1. Préparation des paramètres (Identique à ton ArticleDetail)
            const param = {
                returnType: "application/json",
                page: "search_fetch", // Ta route dans le routeur
                keyword: this.keyword,
                author: this.author,
                limit: this.limit,
                vuejs: true
            };

            // 2. Requête FETCH avec POST
            fetch(window.location.pathname, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(param).toString(),
            })
                .then(response => {
                    if (!response.ok) throw new Error(`Erreur HTTP : ${response.status}`);
                    return response.json();
                })
                .then(json_data => {
                    // On adapte selon la structure renvoyée par ton PHP
                    // Si ton PHP renvoie directement le tableau : this.results = json_data;
                    // Si ton PHP renvoie { articles: [...] } : this.results = json_data.articles;
                    this.results = Array.isArray(json_data) ? json_data : (json_data.articles || []);
                })
                .catch(error => {
                    this.erreur_message = "Erreur lors de la recherche";
                    console.error('Problème avec fetch search:', error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    },

    // Déclenche une première recherche au chargement pour afficher les articles par défaut
    mounted() {
        this.performSearch();
    }
};