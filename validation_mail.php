<?php
require __DIR__ . DIRECTORY_SEPARATOR . "navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."App/User.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."App/HandleDb.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."App/ViewsMsg.php";

if (!empty($_GET)) {
    if (!empty($_GET['log']) && !empty($_GET['mail_key'])) {
        $username = htmlspecialchars(urldecode($_GET['log']));
        $mail_key = htmlspecialchars(urldecode($_GET['mail_key']));
        $user = new User($username, "");
        $return = $user->validation_mail($username, $mail_key);
        if ($return) {
            if ($return == 1) 
                ViewsMsg::alert_message("L'utilisateur n'existe pas dans notre base de donneée veuillez vous inscrire", "danger");
            else {
                ViewsMsg::alert_message("Problème lors de la confirmation par mail veuillez redemander un mail de confirmation", "danger");
                echo <<<HTML
                <div class="container justify-content-center">
                    <div class="row justify-content-center">
                        <div class="card text-center border-primary mb-3 my-4" style="width:18rem;">
                            <div class="card-body justify-content-center">
                                <p class="font-italic">Renvoyer un mail de confirmation:</p> 
                            </div>
                            <a href="/resend_mail.php?log=$username" class="btn btn-primary my-4 mx-4">Valider</a>             
                        </div>        
                    </div>
              </div>
HTML;
            }
        }
        else
            ViewsMsg::alert_message("Bravo, vous êtes désormais inscrit, vous pouvez vous connecter dès maintenant!", "success");
    }
    else {
        ViewsMsg::alert_message("404 ERROR.. vous allez être redirigé", "danger");
        header("Refresh: 3; url='/index.php'");
        exit();
    }
}
else {
    ViewsMsg::alert_message("404 ERROR.. vous allez être redirigé", "danger");
    header("Refresh: 3; url='/index.php'");
    exit();
}