<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

$wrong_username = 0;
$wrong_password = 0;

if (!empty($_POST)) {
    if (empty($_POST['username']) || empty($_POST['pwd'])): {
        viewsMsg::alertMessage("Veuillez remplir tout les champs", "danger");
        exit();
    }
    else: {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['pwd'], PASSWORD_DEFAULT);
        $user = new User($username, "", $password);
        $wrong_username = $user->userExist() ? $wrong_username : 1;
        
        if (!$user->userExist()): {
            viewsMsg::alertMessage("Nom d'utilisateur introuvable, veuillez créer un compte", "danger");
            exit();
        }
        else: {
            if (!$user->dbPasswordVerify()): {
                viewsMsg::alertMessage("Mot de passe incorrect, reinitialiser si vous l'avez oublié", "danger");
                exit();
            }
            elseif ($user->activeAccount() == FALSE): {
                viewsMsg::alertMessage("Veuillez valider votre inscription via le mail reçu", "danger");
                exit();
            }
            else: {
                $_SESSION['online'] = 1;
                $_SESSION['username'] = $username;
                header('Location: /index.php');
            }
            endif;
        }
        endif;
    }
    endif;
}
else {
    viewsMsg::alertMessage("Vous n'êtes pas autorisé à acceder à cette page", "danger");
}