<?php

// On récupère l'ID envoyé par le Fetch dans l'URL (?id=...)
$id = $_GET['id'] ?? null;

if ($id) {
    // Rechercher les données dans le model
    $articleDetails = get_press_article($id);

    // 2. On prépare la réponse en JSON
    header('Content-Type: application/json');
    echo json_encode($articleDetails);
}
exit; // Important : On s'arrête ici, on n'affiche rien d'autre !