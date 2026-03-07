<?php
/**
 * Vue principale de la Home
 * @param array|null $lead L'article phare (un seul tableau)
 * @param array $features Les 3 articles principaux (tableau de tableaux)
 * @param array $sidebar Le reste des articles (tableau de tableaux)
 */
function html_home($lead, $features, $sidebar, $show_articles = true)
{
    $out = '<div class="container-home">';

    // --- 1. & 2. SECTION PRINCIPALE (LEAD + FEATURES) ---
    if ($show_articles) {
        // --- LEAD (Article phare) ---
        if ($lead) {
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

        // --- FEATURES (Articles secondaires) ---
        $out .= <<< HTML
        <div class="main-layout">
            <section class="section-features">
                <h2>À la une cette semaine</h2>
                <div class="grid-features" id="article-app">
HTML;

        // Remplace ton foreach PHP par le composant Vue
        foreach ($features as $art) {
            $id = $art['ident_art'] ?? $art['id'];
            $title = htmlspecialchars($art['title_art'] ?? $art['title']);

            // On remplace le HTML généré par le composant Vue
            $out .= "<article-detail :id='{$id}' title='{$title}'></article-detail>";
        }
        $out .= '</div></section>';

    } else {
        // --- CAS MASQUÉ ---
        $out .= <<< HTML
        <div style="text-align:center; padding:20px; background:#eee; margin-bottom:20px; border-radius:8px;">
            L'article phare et les articles principaux sont masqués.
        </div>
HTML;
    }

    // --- 3. LA SIDEBAR ( Artciles secondaires) ---

    $sidebar_items = "";
    foreach ($sidebar as $art) {
        $id = $art['ident_art'] ?? $art['id'];
        $title = htmlspecialchars($art['title_art'] ?? $art['title']);

        // Ici aussi, on utilise le composant
        $sidebar_items .= "<article-detail :id='{$id}' title='{$title}'></article-detail>";
    }

    $out .= <<< HTML
            <aside class="section-sidebar">
                <h3>Dernières minutes</h3>
                <input type="checkbox" id="toggle-sidebar" class="sidebar-checkbox" hidden>
                <ul>
                    {$sidebar_items}
                </ul>
                <label for="toggle-sidebar" class="btn-sidebar btn-more">Lire plus</label>
                <label for="toggle-sidebar" class="btn-sidebar btn-less">Lire moins</label>
            </aside>
        </div> </div> 
HTML;
    $out .= '
        <script src="/js/vue.global.js"></script>
        <script type="module" src="/public/components/app.js"></script>
    ';
    return $out;
}