// public/components/app.js
console.log("Vue en train de démarrer")
const { createApp } = Vue;
import { ArticleDetail } from './detail.js';
import { FavoriteButton} from "./favorite.js";
import { SearchComponent} from "./search.js";

const app = createApp({
    components: {
        'article-detail': ArticleDetail,
        'favorite-button'  : FavoriteButton,
        'search-composant' : SearchComponent

    }
});
app.mount('#article-app');
console.log("Vue est monté")