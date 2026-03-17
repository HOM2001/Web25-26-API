<?php
function readtime_fetch() {
    $minutes = $_GET['rt-input'];
    $nbrArticles = count_articles_by_time($minutes);

    header('Content-Type: application/json');
    echo json_encode($nbrArticles);
    exit;
}
