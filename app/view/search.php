<?php
function html_search_view($reporters = [], $max_val = 100)
{
    $noms_reporters = array_map(function($rep) {
        return $rep['name_rep'] ?? $rep['name'] ?? 'Inconnu';
    }, $reporters);

    $json_reporters = json_encode($noms_reporters);

    return <<< HTML
    <div id="article-app">
        <script>
            window.REPORTERS = {$json_reporters};
            window.MAX_VAL = {$max_val};
        </script>

        <search-composant></search-composant>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script type="module" src="./components/app.js"></script>
HTML;
}