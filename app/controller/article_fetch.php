<?php
function main_article_fetch() {
    $id = $_GET['ident_art'] ?? 0;
    // Utilise ta fonction de modèle existante
    $article = get_press_article($id);

    header('Content-Type: application/json');
    echo json_encode($article);
    exit;
}