<?php
function detail_fetch() {
    // 1. On récupère l'ID passé dans l'URL par Fetch
    $id = $_REQUEST['ident_art'] ?? $_REQUEST['id'] ?? null;
    if (!$id) {
        echo json_encode(["error" => "ID manquant"]);
        exit;
    }

    // 2. On utilise TA fonction du modèle
    $article = get_press_article($id);

    // 3. On formate la réponse pour Vue.js
    // On s'assure d'envoyer les clés que le composant attend
    $response = [
        'date_creation' => $article['date_creation'] ?? $article['date'] ?? 'Inconnue',
        'categorie'     => $article['categorie'] ?? $article['category'] ?? 'Général',
        'duree_lecture' => $article['a.reading_time'] ?? 5,
        // Pour le bonus Admin
        'role'          => $_SESSION['user_role'] ?? 'user',
        'id'            => $id,
        'auteur'        => $article['auteur'] ?? 'Anonyme'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}