<?php
require_once "../app/config/app.php";
require_once "../app/config/model.php";

/**
 * include all MVC PHP files
 */
function include_mvc_php_files()
{
	// include all PHP files
	foreach ( array( 'model', 'view', 'controller') as $dir )
	{
		$file_a = scandir(ROOT_DIR.$dir);

		foreach ( $file_a as $file)
		{
			if( substr( $file, -4, 4 ) != ".php" ) continue;
			// echo($file."\n");
			require_once( ROOT_DIR.$dir.DIRECTORY_SEPARATOR.$file );
		}
	}

}

///////////////////////////////////////////////////////////////////////////////

// ROUTER
session_start();
include_mvc_php_files();

// 1. Liste des pages qui sont des API JSON (elles ne doivent pas charger de HTML)
$api_pages = ['detail_fetch', 'favorite_fetch','search_fetch'];

$page = @$_REQUEST['page'] ?: 'home';

// 2. Si c'est une page API, on exécute, on affiche et on quitte tout de suite
if (in_array($page, $api_pages)) {
    // On appelle la fonction correspondante (ex: detail_fetch() ou favorite_fetch())
    // Assure-toi que tes fonctions dans les contrôleurs font bien un echo json_encode
    call_user_func($page);
    exit;
}

// 3. Sinon, c'est une page normale, on continue le chargement du site
$header = @$_REQUEST['returnType'] ?: 'text/html; charset=UTF-8';
$main = "main_{$page}";

// OUTPUT
header("Content-Type: $header");
echo $main();
