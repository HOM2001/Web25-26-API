export const ReadtimeCounter = {
    data() {
        return {
            inputTime: 0,
            articleCount: null,
            loading: false
        };
    },
    methods: {
        checkArticles() {
            console.log("Action : Clic sur bouton"); // Pour vérifier si ça répond
            this.loading = true;
            fetch(`index.php?page=readtime_fetch&time=${this.inputTime}`)
                .then(r => r.json())
                .then(data => {
                    this.articleCount = data.count;
                    this.loading = false;
                })
                .catch(() => this.loading = false);
        }
    },
    template: `
    <div class="countArticle">
        <label>Temps de lecture :</label>
        <input type="number" v-model.number="inputTime" min="0">
        <button type="button" @click="checkArticles" class="btn-check">
            Afficher
        </button>
        <div v-if="articleCount !== null">
            {{ articleCount }} articles
        </div>
    </div>`
};