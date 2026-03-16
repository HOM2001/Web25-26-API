<?php
function favorite_fetch() {
    header('Content-Type: application/json');
    $action = $_REQUEST['action'] ?? '';

    // Initialisation session si besoin
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['panier'])) $_SESSION['panier'] = [];

    $response = ['status' => 'error'];

    switch ($action) {
        case 'get_all':
            // Récupère les détails complets des articles en session
            $panier_ids = $_SESSION['panier'];
            $favoris = [];

            // Remplace par ta fonction de récupération (ex: get_press_article ou équivalent)
            foreach ($panier_ids as $id) {
                $article = get_press_article($id);
                if ($article) $favoris[] = $article;
            }

            $response = [
                'status' => 'success',
                'list' => $favoris,
                'role' => $_SESSION['role'] ?? 'user'
            ];
            break;

        case 'add':
        case 'remove':
            $id = $_REQUEST['ident_art'] ?? $_REQUEST['id'] ?? null;
            if ($id) {
                if ($action === 'add' && !in_array($id, $_SESSION['panier'])) {
                    $_SESSION['panier'][] = $id;
                } elseif ($action === 'remove') {
                    $_SESSION['panier'] = array_values(array_filter($_SESSION['panier'], function($item) use ($id) {
                        return $item != $id;
                    }));
                }
                $response = ['status' => 'success'];
            }
            break;
        case 'clear':
            $_SESSION['panier'] = []; // Vide le tableau en session
            echo json_encode(['status' => 'success']);
            break;
    }

    echo json_encode($response);
    exit;
}