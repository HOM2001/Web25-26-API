<?php
function get_readtimes() {

    $sql = "SELECT DISTINCT (readtime_art) 
            FROM t_article 
            WHERE readtime_art IS NOT NULL 
            ORDER BY readtime_art ASC";

    return db_select($sql);
}
function get_articles_by_time($minutes)
{
    $sql = "SELECT ident_art, title_art, hook_art 
            FROM t_article 
            WHERE readtime_art = :minutes";

    $params = ['minutes' => $minutes];

    return db_select_prepare($sql, $params);
}
function count_articles_by_time($minutes) {

    $sql = "Select COUNT(a.id_art) AS article_count
from t_article a
where a.readtime_art IS NOT NULL AND a.readtime_art = :minutes";

    $params = ['minutes' => $minutes];

    return db_select_prepare($sql, $params);
}