export const ArticleDetail = {
    props: ['id', 'title'],

    data() {
        return {
            details: null,
            isLoading: false,
            erreur_message: null
        };
    },

    template: `
        <div class="article-box" @mouseover="fetchDetails" style="border:1px solid #ccc; padding:10px; margin:5px;">
            <h3>{{ title }}</h3>
            
            <div v-if="isLoading">Chargement...</div>
            
            <div v-if="details" class="details-box">
                <p><strong>Date :</strong> {{ details.date_creation }}</p>
                <p><strong>Catégorie :</strong> {{ details.categorie }}</p>
                <p><strong>Auteur :</strong> {{ details.auteur }}</p>
            </div>

            <div v-if="erreur_message" class="erreur" style="color: red;">
                ⚠️ {{ erreur_message }}
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
                id: this.id,
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
        }
    }
};