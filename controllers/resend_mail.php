<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

if (isset($_GET) && !empty($_GET['log'])): {
    $username = htmlspecialchars($_GET['log']);
    $user = new User($username, "", "");
    if ($user->userExist() == FALSE): {
        viewsMsg::alertMessage("Votre compte n'existe pas dans notre base de donnée, veuillez vous inscrire", "danger");
        header("Refresh: 5; url='index.php'");
    }
    else: {
        $user->sendValidationMail(NULL);
        viewsMsg::alertMessage("Consulter vos mails et cliquez sur le lien de validation de compte!", "success");
    }
    endif;
}
else: {
    viewsMsg::alertMessage("ERREUR, ne touchez pas l'URL.. vous allez être redirigé", "danger");
    header("Refresh: 3; url='index.php'");
    exit();
}
endif;