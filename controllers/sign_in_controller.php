<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

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
            viewsMsg::alertMessage("Veuillez remplir tout les champs", "danger");
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
            $pseudo_taken = $user->userExist() ? 1 : $pseudo_taken;
            $mail_error = $user->mailExist($usrmail) ? 2 : $mail_error;
            $pseudo_error = preg_match("`^[a-z0-9](-?[a-z0-9])*$`", $username) ? 1 : 0;

            if (!$mail_error && $pseudo_error && !$password_error && !$pseudo_taken) {
                $user->signIn([$username, $usrmail, $password, $mail_key, 0, 0]);
                $user->sendValidationMail($mail_key);
                viewsMsg::alertMessage("Félicitation, il ne vous reste plus qu'à valider votre compte via le lien reçu sur votre boite mail", "success");
            }
    }
    endif;
    }
    require_once dirname(__DIR__) . "/views/sign_in_view.php";
}
else: {
    viewsMsg::alertMessage("Page introuvable, vous allez être redirigé..", "danger");
    viewsMsg::indexRedirection(3);
}
endif;
