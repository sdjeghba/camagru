<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/user.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/databaseManager.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/viewsMsg.class.php";

$username_error = 0;
$password_error = 0;
$pseudo_error = 95;
$sucess = 0;

if (empty($_SESSION['online'])): {
    if (!empty($_POST)) {
        if (empty($_POST['usrname'])): {
            viewsMsg::alert_message("Veuillez remplir tout les champs", "danger");
            exit();
        }
        else: {
            $username = htmlspecialchars($_POST['usrname']);
            $user = new User($username, $username, "");
            if ($user->user_not_found()){
                $success = 1;
                $user->send_reset_password_mail();
                viewsMsg::alert_message("Vous allez reçevoir un mail de reinitialisation, vérifier votre boite de réception et votre courrier indésirable", "success");
            }
            else {
                viewsMsg::alert_message("Votre nom d'utilisateur ou votre mail nous ai inconnu, veuillez vous inscrire", "danger");
            }
        }
        endif;
    }
    if (empty($success)) {
        require_once dirname(__DIR__) . "/views/resend_password_view.php";
    }
}
else: {
    viewsMsg::alert_message("Page introuvable, vous allez être redirigé..", "danger");
    viewsMsg::index_redirection();
}
endif;