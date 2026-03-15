<?php
function html_search_view($reporters = [], $max_val = 100)
{
    // 1. On prépare les données PHP pour le JavaScript (JSON)
    // On nettoie les noms des reporters pour le select de Vue
    $json_reporters = json_encode(array_map(function($rep) {
        return ['name' => $rep['name_rep'] ?? $rep['name'] ?? 'Inconnu'];
    }, $reporters));

    // 2. Retour d'une seule chaîne HTML contenant le conteneur Vue
    return <<< HTML
    <div id="article-app">
        <script>
            window.REPORTERS = {$json_reporters};
            window.MAX_VAL = {$max_val};
        </script>

        <search-composant></search-composant>
    </div>
<script type="module" src="./public/components/app.js"></script>
HTML;
}