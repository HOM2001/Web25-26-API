<?php
/*
 * Create a form with login log out option and close it then display it
 */



function html_logout_button()
{
    ob_start();
    ?>
    <div class="container-fluid mb-3">
        <a href="?page=login&action=logout">log out</a>
    </div>
    <?php
    return ob_get_clean();
}

function html_unidentified_user()
{
    if(AUTH_METHOD == "CSV") {
        return html_unidentified_user_CSV();
    }else if(AUTH_METHOD == "API") {
        return html_unidentified_user_API();
    }

}
function html_unidentified_user_CSV()
{
    return <<< HTML
    <div class="col-mb-3">
        <h3>Connectez-vous</h3>
        <label for="identifier" class="form-label">Votre Identifiant</label>
        <input type="text" class="form-control" name="identifier" placeholder="Identifiant">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" placeholder="Mot de passe">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Connexion</button>
    </div>
HTML;

}
function html_unidentified_user_API()
{
    return <<< HTML
    <br>
        <h3>Connectez-vous</h3>
        <div class="row justify-content-center">
            <div class="col-5">
                <label for="identifier" class="form-label">Pseudo</label>
                <input type="text" class="form-control" name="identifier" placeholder="Pseudo">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-5">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
        </div>
HTML;
}


function html_link_home()
{
    ob_start();
    ?>
    <br>
    <div class="container-fluid mb-3">
        <p>
            <a href=".">Aller à la page principale</a>
        </p>
    </div>
    <?php
    return ob_get_clean();
}

function html_open_form()
{
    ob_start();
    ?>
    <form method="post">
    <div class="container">
    <?php
    return ob_get_clean();
}


function html_close_form()
{
    ob_start();
    ?>
    </div>
    </form>
    <?php
    return ob_get_clean();
}