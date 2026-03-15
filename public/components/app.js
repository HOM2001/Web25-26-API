// public/components/app.js
console.log("Vue en train de démarrer")
const { createApp } = Vue;
import { ArticleDetail } from './detail.js';
import { FavoriteButton} from "./favorite.js";

const app = createApp({
    components: {
        'article-detail': ArticleDetail,
        'article-favoris'  : FavoriteButton
    }
});
app.mount('#article-app');