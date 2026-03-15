<?php
function main_search(): string {
    // 1. On garde uniquement la préparation des données pour le formulaire
    $reporters = get_reporter() ?? [];
    $max_articles = get_top_reporter() ?? [['nb_articles' => 100]];
    $max_val = $max_articles[0]['nb_articles'] ?? 100;

    // 2. On appelle la vue unique qui contient le composant Vue.js
    return join("\n", [
        ctrl_head(),
        html_search_view($reporters, $max_val),
        html_foot()
    ]);
}