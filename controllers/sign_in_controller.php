<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/user.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/databaseManager.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/viewsMsg.class.php";

$mail_error = 0;
$pseudo_error = 95;
$username_error = 0;
$password_error = 0;
$pseudo_taken = 0;

/*
    Proceed to form verifications, if it's ok we go to the else to create the user and send the mail confirmation.
*/

if (empty($_SESSION['online'])): {
    if (!empty($_POST)) {
        if (empty($_POST['mail']) || empty($_POST['pwd']) || empty($_POST['usrname'])): {
            viewsMsg::alert_message("Veuillez remplir tout les champs", "danger");
            exit();
        }
        elseif (User::checkMail(htmlspecialchars($_POST['mail'])) == FALSE): { 
            $mail_error = 1;
        }
        else: {
            $username = htmlspecialchars($_POST['usrname']);
            $usrmail = htmlspecialchars($_POST['mail']);
            $password = password_hash(htmlspecialchars($_POST['pwd']), PASSWORD_DEFAULT);
            $mail_key = md5(microtime(TRUE)*10000);
            $user = new User($username, $usrmail, $password);

            $password_error = htmlspecialchars(($_POST['pwd']) != htmlspecialchars($_POST['pwd2'])) ? 1 : $password_error;
            $password_error = $_POST['pwd'] && $user->securePwd($_POST['pwd']) == FALSE ? 2 : $password_error; 
            $pseudo_taken = $user->user_exist() ? 1 : $pseudo_taken;
            $mail_error = $user->mail_exist($usrmail) ? 2 : $mail_error;
            $pseudo_error = preg_match("`^[a-z0-9](-?[a-z0-9])*$`", $username) ? 1 : 0;

            if (!$mail_error && $pseudo_error && !$password_error && !$pseudo_taken) {
                $user->sign_in([$username, $usrmail, $password, $mail_key, 0]);
                $user->send_validation_mail($mail_key);
                viewsMsg::alert_message("Félicitation, il ne vous reste plus qu'à valider votre compte via le lien reçu sur votre boite mail", "success");
            }
    }
    endif;
    }
    require_once dirname(__DIR__) . "/views/sign_in_view.php";
}
else: {
    viewsMsg::alert_message("Page introuvable, vous allez être redirigé..", "danger");
    viewsMsg::index_redirection();
}
endif;
