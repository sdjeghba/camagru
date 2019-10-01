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
            else
                ViewsMsg::alert_message("Problème lors de la confirmation par mail veuillez redemandé un mail de confirmation", "danger");
        }
        else
            ViewsMsg::alert_message("Grand Success", "success");
    }
    else {
        ViewsMsg::alert_message("probleme dans une variable", "danger");
    }
}
else {
    ViewsMsg::alert_message("probleme", "danger");
}