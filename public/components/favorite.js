// public/components/favorite_app.js
export const FavoriteApp = {
    data() {
        return {
            favoris: [] // Contiendra les IDs
        };
    },
    methods: {
        async toggleFavorite(id) {
            const action = this.favoris.includes(id) ? 'remove' : 'add';

            const response = await fetch('?page=favorite_fetch', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id: id, action: action })
            });

            const data = await response.json();

            // Mise à jour de l'état local avec la réponse du contrôleur
            this.favoris = data.all_favorites;
        }
    }
};