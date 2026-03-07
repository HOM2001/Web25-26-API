// public/components/app.js
console.log("Vue en train de démarrer")
const { createApp } = Vue;
import { ArticleDetail } from './detail.js';

const app = createApp({
    components: { 'article-detail': ArticleDetail }
});
app.mount('#article-app');