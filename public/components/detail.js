export const ArticleDetail = {

    props: ['id', 'title', 'image', 'hook'],

    data() {
        return {
            details: null,
            isLoading: false,
            erreur_message: null,
            role : null
        };
    },

    template: `
    <div class="card-feature" @mouseover="fetchDetails" @mouseleave="clearDetails">
        <h3>{{ title }}</h3>
        
        <div class="media-feature" v-if="image">
            <img :src="image" :alt="title">
        </div>
        
        <p>{{ hook }}</p>

        <div v-if="isLoading">Chargement des détails...</div>
        
        <teleport to="#info-display-zone" v-if="details">
            <div class="fixed-details-content">
                <div class="meta-item"><strong>Date :</strong> {{ details.date_creation }}</div>
                <div class="meta-item"><strong>Lecture :</strong> {{ details.temps_lecture }} min</div>
                <div class="meta-item"><strong>Catégorie :</strong> {{ details.categorie }}</div>

                <div v-if="role === 'admin'" class="admin-details" style="margin-top:10px; border-top:1px solid #ccc; pt:5px;">
                    <p><strong>Titre complet :</strong> {{ details.title }}</p>
                    <p><strong>Auteur :</strong> {{ details.auteur }}</p>
                    <p><strong>ID Article :</strong> {{ details.id }}</p>
                    <p><strong>ID Image :</strong> {{ details.image_id }}</p>
                </div>
            </div>
        </teleport>
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
                    this.details = json_data.article;
                    this.role = json_data.role;
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