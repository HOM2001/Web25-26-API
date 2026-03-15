<?php
function html_banner() {
    $data = get_banner(); // Ton relais PHP

    if (!$data || !isset($data['banner_4IPDW'])) return "";

    $b = $data['banner_4IPDW'];

    // Préparation des variables
    $link = htmlspecialchars($b['link']);
    $color = htmlspecialchars($b['color']);
    $text = nl2br(htmlspecialchars($b['text']));
    $img1 = htmlspecialchars($b['image']);
    $img2 = htmlspecialchars($b['background_image']);

    $html = <<<HTML
    <div style="background-color: $color; background-image:$img2; 20px; margin: 20px 0; border: 2px solid #333; border-radius: 8px; text-align: center; font-family: sans-serif;">
        <a href="$link" target="_blank" style="text-decoration: none; color: #000;">
            <div style="margin-bottom: 15px;">
                <p style="font-weight: bold; font-size: 1.1em;">$text</p>
            </div>
            <div style="display: flex; justify-content: center; gap: 15px;">
                <img src="$img1" alt="Pub" style="max-height: 100px; border: 1px solid #fff;">
            </div>
        </a>
    </div>
HTML;

    return $html;
}