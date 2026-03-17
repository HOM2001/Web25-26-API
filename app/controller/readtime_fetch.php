<?php
function readtime_fetch() {

    $minutes = isset($_GET['time']) ? (int)$_GET['time'] : 0;

    $nbrArticles = count_articles_by_time($minutes);
    $total_article = $nbrArticles[0]["article_count"];

    $response = [
        'count' => (int)$total_article,
    ];

    header('Content-Type: application/json');

    echo json_encode($response);
    exit;
}