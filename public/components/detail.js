export const ArticleDetail = {

    props: ['id', 'title', 'image', 'hook'],

    data() {
        return {
            details: null,
            isLoading: false,
            erreur_message: null
        };
    },

    template: `
    <div class= "card-feature" @mouseover="fetchDetails" @mouseleave="clearDetails">
        <h3>{{ title }}</h3>
        <a :href="'?page=article&ident_art=' + id" class="card-link">
        <div class="media-feature" v-if="image">
            <img :src="image" :alt="title">
        </div>
        
        <p>{{ hook }}</p>

       <a :href="'?page=article&ident_art=' + id" class="read-more">En savoir plus</a>
        <div v-if="isLoading">Chargement...</div>
        
        <div v-if="details && !erreur_message" class="details-box">
        <br>
            <p><strong>Date :</strong> {{ details.date_creation.split('-').reverse().join('-') }}</p>
            <p><strong>Catégorie :</strong> {{ details.categorie }}</p>
            <p><strong>Auteur :</strong> {{ details.auteur }}</p>
        </div>
    </div>
`,

    methods: {
        fetchDetails() {
            // Si déjà chargé ou en cours, on ne fait rien
            if (this.details || this.isLoading) return;

            this.isLoading = true;
            this.erreur_message = null;

            // 1. Préparation des paramètres comme l'exemple du prof
            const param = {
                returnType: "application/json",
                page: "detail_fetch",
                ident_art: this.id,
                vuejs: true
            };

            // 2. Requête FETCH avec POST (comme le prof)
            fetch(window.location.pathname, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(param).toString(),
            })
                .then(response => {
                    if (!response.ok) throw new Error(`Erreur HTTP : ${response.status}`);

                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error("La réponse n'est pas au format JSON");
                    }
                    return response.json();
                })
                .then(json_data => {
                    console.log(json_data)
                    // 3. Mise à jour des données
                    this.details = json_data;
                })
                .catch(error => {
                    this.erreur_message = error.message;
                    console.error('Problème avec fetch:', error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        clearDetails(){
            this.details = null;
            this.erreur_message = null;
        }
    }
};