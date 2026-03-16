<?php
function main_login()
{
    $action = $_GET['action'] ?? "";
    $msg = '';

    // 1. GESTION DE LA DÉCONNEXION (Redirection immédiate)
    if ($action === 'logout') {
        session_unset();
        session_destroy();
        // Redirection vers la home après déconnexion
        header('Location: index.php?page=home');
        exit();
    }

    // 2. GESTION DE LA CONNEXION (POST)
    $login = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($login && $password) {
        list($valide, $id_user, $role_user) = check_login($login, $password);

        if ($valide) {
            $_SESSION['id'] = $id_user;
            $_SESSION['role'] = $role_user;
            // Optionnel : Redirection vers home après connexion réussie
            header('Location: index.php?page=home');
            exit();
        } else {
            unset($_SESSION['id']);
            unset($_SESSION['role']);
            $msg = "<p style='color:red;'>Identifiant ou mot de passe incorrect.</p>";
        }
    }

    // 3. AFFICHAGE DU FORMULAIRE
    // Si l'utilisateur est connecté, on affiche le bouton logout, sinon le formulaire
    $content = isset($_SESSION['id']) ? html_logout_button() : html_unidentified_user();

    return join("\n", [
        ctrl_head(),
        html_open_form(),
        $msg,
        $content,
        html_link_home(),
        html_close_form(),
        html_foot()
    ]);
}
?>