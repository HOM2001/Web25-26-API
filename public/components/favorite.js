export const FavoriteButton = {
    data() {
        return {
            articles: window.ARTICLES || [],
            panier: [],
            isLoadingPanier: false
        };
    },
    // Ajout des propriétés calculées pour l'affichage dynamique
    computed: {
        // Nombre total d'articles favoris
        totalFavoris() {
            return this.panier.length;
        },
        // Liste des 5 premiers titres seulement
        top5Favoris() {
            return this.panier.slice(0, 5);
        }
    },
    mounted() {
        this.fetchPanier();
    },
    methods: {
        // ... tes méthodes existantes (fetchPanier, toggleFav, etc.) restent identiques
        fetchPanier() {
            fetch('index.php?page=favorite_fetch&action=get_all')
                .then(response => response.json())
                .then(data => {
                    this.panier = data.list || [];
                });
        },
        toggleFav(art) {
            const isFav = this.panier.some(f => f.ident_art === art.ident_art);
            const action = isFav ? 'remove' : 'add';
            fetch(`index.php?page=favorite_fetch&action=${action}&ident_art=${art.ident_art}`)
                .then(response => response.json())
                .then(() => { this.fetchPanier(); });
        },
        isInPanier(id) {
            return this.panier.some(f => f.ident_art === id);
        },
        clearPanier() {
            fetch('index.php?page=favorite_fetch&action=clear')
                .then(() => this.fetchPanier());
        }
    },
    template: `
<div class="favorite-page">
    
    <div class="favorite-stats-box">
        <h3>Résumé des favoris</h3>
        <p>Total : <strong>{{ totalFavoris }} articles</strong></p>
        <ul v-if="totalFavoris > 0">
            <li v-for="item in top5Favoris" :key="item.ident_art">
                {{ item.title_art }} 
                <button @click="toggleFav(item)" class="btn-remove-fav">X</button>
            </li>
        </ul><button v-if="panier.length > 0" @click="clearPanier" class="btn-delete">Vider le panier</button>
        <p v-else>Aucun favori.</p>
    </div>

   

    <section class="favorite">
        <h1>Catalogue</h1>
        <div class="favorite-grid">
            <div v-for="art in articles" :key="art.ident_art" class="article-container">
                <div class="article-content">
                    <img :src="'./media/' + (art.image_art || 'default.jpg')" :alt="art.title_art">
                    <h3>{{ art.title_art }}</h3>
                    <button 
                        @click="toggleFav(art)" 
                        :class="['btn-fav', isInPanier(art.ident_art) ? 'active' : '']">
                        {{ isInPanier(art.ident_art) ? 'Retirer' : 'Ajouter' }}
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
`
};