<?php
function html_home($lead, $features, $sidebar, $show_articles = true)
{
// 1. Ouverture du conteneur VUE (englobe TOUT pour que Vue gère features et sidebar)
$out = '<div id="article-app" class="container-home">';

    // --- SECTION LEAD (Article phare) ---
    if ($show_articles && $lead) {
    $id_lead = $lead['ident_art'] ?? $lead['id'];
    $title_lead = $lead['title_art'] ?? $lead['title'];
    $hook_lead = $lead['hook_art'] ?? $lead['hook'] ?? "";
    $image_lead = $lead['image_art'] ?? "default.jpg";
    $media_path_lead = MEDIA_PATH . $image_lead;

    $out .= <<< HTML
    <section class="section-lead">
        <article class="article-phare">
            <div class="media-phare">
                <img src="{$media_path_lead}" alt="{$title_lead}">
            </div>
            <div class="phare-content">
                <span class="badge">À la une</span>
                <h1>{$title_lead}</h1>
                <p>{$hook_lead}</p>
                <a href="?page=article&ident_art={$id_lead}" class="btn-phare">Lire l'article complet</a>
            </div>
        </article>
    </section>
    HTML;
    }

    // --- SECTION FEATURES ---
    if ($show_articles) {
    $out .= '<section class="section-features">
        <h2>À la une cette semaine</h2>
        <div class="grid-features">';
            foreach ($features as $art) {
            $id = $art['ident_art'] ?? $art['id'];
            $title = htmlspecialchars($art['title_art'] ?? $art['title']);
            $out .= "<article-detail :id='{$id}' title='{$title}'></article-detail>";
            }
            $out .= '</div></section>';
    }

    // --- SECTION SIDEBAR ---
    $out .= '<aside class="section-sidebar">
        <h3>Dernières minutes</h3>
        <ul>';
            foreach ($sidebar as $art) {
            $id = $art['ident_art'] ?? $art['id'];
            $title = htmlspecialchars($art['title_art'] ?? $art['title']);
            $out .= "<article-detail :id='{$id}' title='{$title}'></article-detail>";
            }
            $out .= '</ul></aside>';

    // 2. Fermeture du conteneur VUE
    $out .= '</div>';

// 3. Chargement des scripts
    $out .= '
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script type="module" src="./components/app.js"></script>
';

return $out;
}