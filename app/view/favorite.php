<?php
/*
 * Display a cart for add favorite article in the cart
 */
function html_panier_favorite() : string{
    $total_articles = get_article_count();
    if(DATABASE_TYPE === 'MySql'){
        $articles = get_sql('','recent',10);
    }elseif (DATABASE_TYPE === 'json') {
        $content_a = get_all_json_data();

        $articles  = array_slice($content_a, 0, 20);

    }
// 2. Préparation des données pour Vue
    $articles_json = json_encode($articles);

    ob_start();
    ?>
    <div id="article-app">
        <favorite-button></favorite-button>
    </div>

    <script>
        // On injecte les données globales pour que le composant puisse les utiliser
        window.ARTICLES = <?php echo $articles_json; ?>;
    </script>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script type="module" src="./components/app.js"></script>
    <?php
    return ob_get_clean();
}
