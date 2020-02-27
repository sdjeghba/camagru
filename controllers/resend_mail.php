<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . "content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."models/User.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."models/HandleDb.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."models/ViewsMsg.php";

if (isset($_GET) && !empty($_GET['log'])): {
    $username = htmlspecialchars($_GET['log']);
    $user = new User($username, "", "");
    if ($user->user_exist() == FALSE): {
        ViewsMsg::alert_message("Votre compte n'existe pas dans notre base de donnée, veuillez vous inscrire", "danger");
        header("Refresh: 5; url='index.php'");
    }
    else: {
        $user->send_validation_mail(NULL);
        ViewsMsg::alert_message("Consulter vos mails et cliquez sur le lien de validation de compte!", "success");
    }
    endif;
}
else: {
    ViewsMsg::alert_message("ERREUR, ne touchez pas l'URL.. vous allez être redirigé", "danger");
    header("Refresh: 3; url='index.php'");
    exit();
}
endif;