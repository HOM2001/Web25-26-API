<?php
function favorite_fetch() {
    // 1. On récupère l'ID et l'action passés par Fetch
    $id = $_POST['id'] ?? null;
    $action = $_POST['action'] ?? null; // 'add' ou 'remove'

    if (!$id || !$action) {
        header('Content-Type: application/json', true, 400);
        echo json_encode(["error" => "ID ou action manquant"]);
        exit;
    }

    // 2. Initialisation de la session panier si elle n'existe pas
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // 3. Logique métier : Modification du panier dans la session
    if ($action === 'add') {
        if (!in_array($id, $_SESSION['panier'])) {
            $_SESSION['panier'][] = $id;
        }
    } elseif ($action === 'remove') {
        $_SESSION['panier'] = array_diff($_SESSION['panier'], [$id]);
    }

    // 4. Préparation de la réponse
    // On renvoie le nouvel état du panier (la liste complète des IDs)
    $response = [
        'is_favorite' => in_array($id, $_SESSION['panier']),
        'all_favorites' => array_values($_SESSION['panier']),
        'count' => count($_SESSION['panier'])
    ];

    // 5. Envoi au format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}