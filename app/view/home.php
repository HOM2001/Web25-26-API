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
            $image = $art['image_art'] ?? "default.jpg";
            $media_path_lead = MEDIA_PATH . $image;
            $hook = htmlspecialchars($art['hook_art'] ?? $art['hook'] ?? "");
            $out .= "<article-detail :id='{$id}' title='{$title}' image='{$media_path_lead}' hook='$hook' ></article-detail>";
            }
            $out .= '</div></section>';
    }

    // --- SECTION SIDEBAR ---
    $out .= '<aside class="section-sidebar" id="sidebar-app">';
    $out .= '<h2>Dernières minutes</h2>';
    $out .= '<div id="info-display-zone">';
    $out .= '<p class="placeholder-text">Survolez un article pour voir les détails ici.</p>';
    $out .= '</div>';

    foreach ($sidebar as $art) {
        $id = $art['ident_art'] ?? $art['id'];
        $title = htmlspecialchars($art['title_art'] ?? $art['title']);
        $hook = htmlspecialchars($art['hook_art'] ?? $art['hook'] ?? "");
        $hook_sidebar = limit_words($hook, LIMIT_WORD_SIDEBAR);

        $out .= "<div><article-detail :id='{$id}' title='\"{$title}\"' hook='\"{$hook_sidebar}\"'></article-detail></div>";

    }


// Le bouton qui va déclencher l'affichage
    $out .= '<button id="btn-more" onclick="showMore()">Voir plus</button>';
    $out .= '<button id="btn-less" class="btn-sidebar" onclick="showLess()" style="display:none;">Voir moins</button>';
    $out .= '</aside>';
    // 2. Fermeture du conteneur VUE
    $out .= '</div>';

// 3. Chargement des scripts
    $out .= '
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script type="module" src="./components/app.js"></script>
    <script src="./js/internal/main.js"></script>
';

return $out;
}