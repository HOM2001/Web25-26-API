export const FavoriteButton = {
    data() {
        return {
            articles: window.ARTICLES || [],
            panier: [],
            isLoadingPanier: false
        };
    },
    mounted() {
        this.fetchPanier();
    },
    methods: {
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
                .then(() => {
                    this.fetchPanier(); // Rafraîchit le panier après l'action
                });
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
    
    <div id="panier" class="panier-style">
        <h2>Votre Liste de favoris</h2>
        <ul id="panier_contenu">
            <li v-for="item in panier" :key="item.ident_art">
                <div>
                    <span class="read-time-badge">{{ item.readtime_art || 0 }} min</span>
                    <strong>{{ item.title_art }}</strong>
                </div>
                <button @click="toggleFav(item)" class="btn-remove-fav"></button>
            </li>
            <li v-if="panier.length === 0">Votre panier est vide.</li>
        </ul>
        
        <button v-if="panier.length > 0" @click="clearPanier" class="btn-delete">Vider le panier</button>
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