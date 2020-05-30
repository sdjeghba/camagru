<?php
require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

$username_error = 0;
$password_error = 0;
$pseudo_error = 95;
$sucess = 0;


if (empty($_SESSION['online'])): {
    if (!empty($_POST)) {
        if (empty($_POST['usrname'])): {
            viewsMsg::alertMessage("Veuillez remplir tout les champs", "danger");
            exit();
        }
        else: {
            $username = htmlspecialchars($_POST['usrname']);
            $user = new User($username, $username, "");
            if ($user->userNotFound()){
                $success = 1;
                $user->sendResetPasswordMail();
                viewsMsg::alertMessage("Vous allez reçevoir un mail de reinitialisation, vérifier votre boite de réception et votre courrier indésirable", "success");
                viewsMsg::indexRedirection(7);
            }
            else {
                viewsMsg::alertMessage("Votre nom d'utilisateur ou votre mail nous est inconnu, veuillez vous inscrire", "danger");
            }
        }
        endif;
    }
    if (empty($success)) {
        require_once dirname(__DIR__) . "/views/resend_password_view.php";
    }
}
else: {
    viewsMsg::alertMessage("Page introuvable, vous allez être redirigé..", "danger");
    viewsMsg::indexRedirection(3);
}
endif;