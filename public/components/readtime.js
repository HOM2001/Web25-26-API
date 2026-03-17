export const ReadtimeCounter = {
    data() {
        return {
            inputTime: 0,
            articleCount: null,
            loading: false
        };
    },
    methods: {
        async fetchArticles() {
            if (this.inputTime < 0) return;
            this.loading = true;
            try {
                const response = await fetch(`index.php?page=readtime_fetch&time=${this.inputTime}`);
                const data = await response.json();
                this.articleCount = data.count;
            } catch (e) {
                console.error("Erreur:", e);
                this.articleCount = 0;
            } finally {
                this.loading = false;
            }
        }
    },
    template: `
        <div class="readtime-footer-widget">
            <label>Temps de lecture :</label>
            <input type="number" v-model.number="inputTime" min="0" >
            <button type="button" @click="fetchArticles" class="btn-readtime">
                Afficher
            </button>
            <span v-if="articleCount !== null" >
                {{ loading ? '...' : articleCount + ' article(s)' }}
            </span>
        </div>
    `
};