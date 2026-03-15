<?php
function get_banner()
{
    $json_url = "http://playground.burotix.be/adv/banner_for_isfce.json";

    try {
        $json_data = file_get_contents($json_url);
        if ($json_data == null) {
            throw new Exception("Erreur : le fichier JSON est vide");
        }
        $banner = json_decode($json_data, true);
        if ($banner == null || !isset($banner['banner_4IPDW'])) {
            throw new Exception("Erreur : JSON invalide");
        }
        return $banner;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}