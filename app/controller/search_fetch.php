<?php
function search_fetch() {
    // En SPA, on reçoit souvent les données en GET via l'URL
    $keyword = $_GET['keyword'] ?? '';
    $author = $_GET['author'] ?? '';
    $limit = $_GET['limit'] ?? 10;

    // On utilise ta fonction modèle existante
    $results = search($author, $keyword, $limit);

    // On répond proprement en JSON
    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}