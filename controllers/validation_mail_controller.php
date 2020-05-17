<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."models/user.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."models/databaseManager.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."models/viewsMsg.class.php";
$_SESSION['online'] = 0;

/*
By validation_mail method in user.class.php check if the user already exist and if the key is true,
if it's ok set active to 1 in database and the inscription is valid.
Or resend mail validation.
Or errors_messages.

*/
$username_error = 0;
$password_error = 0;

if (!empty($_GET)) {
    if (!empty($_GET['log']) && !empty($_GET['mail_key'])) {
        $username = htmlspecialchars(urldecode($_GET['log']));
        $mail_key = htmlspecialchars(urldecode($_GET['mail_key']));
        $user = new User($username, "", "");
        $return = $user->validation_mail($username, $mail_key);

        if ($return) {
            if ($return == 1) 
                viewsMsg::alert_message("L'utilisateur n'existe pas dans notre base de donneée veuillez vous inscrire", "danger");
            else {
                viewsMsg::alert_message("Problème lors de la confirmation par mail veuillez redemander un mail de confirmation", "danger");
                if ($_SESSION['online'] == 1): {
                echo <<<HTML
                <div class="container justify-content-center">
                    <div class="row justify-content-center">
                        <div class="card text-center border-primary mb-3 my-4" style="width:18rem;">
                            <div class="card-body justify-content-center">
                                <p class="font-italic">Renvoyer un mail de confirmation:</p> 
                            </div>
                            <a href="/controllers/resend_mail.php?log=$username" class="btn btn-primary my-4 mx-4">Valider</a>             
                        </div>        
                    </div>
              </div>
HTML;
                }
                else: {
                    viewsMsg::alert_message("Veuillez vous connectez afin de reçevoir un nouveau mail de confirmation", "danger");
                }
                endif;
            }
        }
        else
            viewsMsg::alert_message("Bravo, vous êtes désormais inscrit, vous pouvez vous connecter dès maintenant!", "success");
    }
    else {
        viewsMsg::alert_message("404 ERROR.. vous allez être redirigé", "danger");
        header("Refresh: 3; url='/index.php'");
        exit();
    }
}
else {
    viewsMsg::alert_message("404 ERROR.. vous allez être redirigé", "danger");
    header("Refresh: 3; url='/index.php'");
    exit();
}