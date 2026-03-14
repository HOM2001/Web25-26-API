<?php
function main_login()
{
    $action = $_GET['action'] ?? "";
    $msg = '';


    if ($action === 'logout') {

        session_unset();
        session_destroy();
        $msg = 'Vous êtes déconnecté.';
    }

    $login = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';

    // GESTION DU LOGIN (CONNEXION)
    if ($login && $password) {
        // Appelle ta fonction de vérification (qui doit faire le relais serveur-serveur)
        list($valide, $id_user, $role_user) = check_login($login, $password);

        if ($valide) {

            $_SESSION['id'] = $id_user;
            $_SESSION['role'] = $role_user;

            $msg = "Vous êtes connecté, bienvenue " . htmlspecialchars($_SESSION['id']) . ", vous êtes l'". $_SESSION['role'] . " du site! ";
        } else {
            unset($_SESSION['id']);
            unset($_SESSION['role']);
            $msg = "Identifiant ou mot de passe incorrect, veuillez réessayer.";
        }
    }

    $msg .= isset($_SESSION['id']) ? html_logout_button() : html_unidentified_user();

    return join("\n", [
        ctrl_head(),
        html_open_form(),
        $msg,
        html_link_home(),
        html_close_form(),
        html_foot()
    ]);
}
?>