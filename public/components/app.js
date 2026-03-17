// public/components/app.js
import { ArticleDetail } from './detail.js';
import { FavoriteButton } from "./favorite.js";
import { SearchComponent } from "./search.js";
import { ReadtimeCounter } from "./readtime.js";

const { createApp } = Vue;

// 1. Instance Catalogue (Haut de page)
const app1 = createApp({
    components: {
        'article-detail': ArticleDetail,
        'favorite-button': FavoriteButton,
        'search-composant': SearchComponent
    }
});
app1.mount('#article-app');

// 2. Instance Footer (Bas de page)
// On crée une fonction pour monter la 2ème app
const mountFooterApp = () => {
    const el = document.getElementById('readtime-app');
    if (el) {
        const app2 = createApp({
            components: {
                'reading-time-counter': ReadtimeCounter
            }
        });
        app2.mount('#readtime-app');
        console.log("App Footer : OK");
    }
};

// On essaie de monter immédiatement et au cas où, après le chargement du DOM
mountFooterApp();
window.addEventListener('load', mountFooterApp);