import { ArticleDetail } from './detail.js';
import { FavoriteButton } from "./favorite.js";
import { SearchComponent } from "./search.js";
import { ReadtimeCounter } from "./readtime.js";

const { createApp } = Vue;

const app1 = createApp({
    components: {
        'article-detail': ArticleDetail,
        'favorite-button': FavoriteButton,
        'search-composant': SearchComponent
    }
});
app1.mount('#article-app');

// 2. Instance Footer - Montage sécurisé
// On utilise une seule exécution pour éviter de "tuer" le bouton
const initFooter = () => {
    const el = document.getElementById('readtime-app');
    // On vérifie si l'élément existe ET s'il n'a pas déjà été monté par Vue
    if (el && !el.__vue_app__) {
        const app2 = createApp({
            components: {
                'reading-time-counter': ReadtimeCounter
            }
        });
        app2.mount('#readtime-app');
        console.log("App Footer : Connectée et prête");
    }
};

// On lance le montage dès que le script est lu
initFooter();

// Au cas où le footer arrive tardivement (chargement asynchrone)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFooter);
}