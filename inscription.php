<?php
require __DIR__ . DIRECTORY_SEPARATOR . "navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/User.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/HandleDb.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/ViewsMsg.php";


var_dump($_POST);
if (!empty($_POST)) {
    if (empty($_POST['mail']) || empty($_POST['pwd'])): {
        ViewsMsg::alert_message("E-mail ou mot de passe manquant", "danger");
    }
    else: {
        $username = htmlspecialchars($_POST['usrname']);
        $usrmail = htmlspecialchars($_POST['mail']);
        // $password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        // $key_mail = md5(microtime(TRUE)*10000);
        // $active = 0;
        // $user = new User($username, $password);
        // if ($user->sign_in(['username','mail','password', 'mail_key', 'active'], [$username, $usrmail, $password. $key_mail, $active], 'users') == FALSE) {
        //     ViewsMsg::alert_message("Nom d'utilisateurs déjà pris veuillez en choisir un autre", "danger");
        }
        ViewsMsg::alert_message("we're here", "success");
    }
    endif;
}
else {
    ViewsMsg::alert_message("chelou", "danger");
}