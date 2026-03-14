<?php
function detail_fetch() {
    // 1. On récupère l'ID passé dans l'URL par Fetch
    $id = $_REQUEST['ident_art'] ?? $_REQUEST['id'] ?? null;
    if (!$id) {
        echo json_encode(["error" => "ID manquant"]);
        exit;
    }

    // Dans ton fichier controller/detail_fetch.php ou ton point d'entrée API
    $article_data = get_press_article($id); // ta fonction existante

    $response = [
        'article' => $article_data,
        'role' => $_SESSION['role'] ?? 'user' // IMPORTANT: transmettre le rôle ici
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}