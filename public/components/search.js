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
                    <option v-for="nom in reporters" :key="nom" :value="nom">
                        {{ nom }}
                    </option>
                </select>
            </div>

            <div class="field">
                <label>Résultats max :</label>
                <input type="number" v-model="limit" @input="performSearch" min="1" max="100">
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
            this.isLoading = true;

            // On construit l'URL avec les paramètres en GET
            const url = `index.php?page=search_fetch&keyword=${encodeURIComponent(this.keyword)}&author=${encodeURIComponent(this.author)}&limit=${this.limit}`;

            fetch(url, {
                method: 'GET' // On passe en GET
            })
                .then(response => response.json())
                .then(json_data => {
                    this.results = json_data;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    },

    // Déclenche une première recherche au chargement pour afficher les articles par défaut
    mounted() {
        console.log("Le composant Search est bien monté !");
        this.performSearch();
    }
};