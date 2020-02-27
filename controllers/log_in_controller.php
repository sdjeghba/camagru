<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/User.php";

$wrong_username = 0;
$wrong_password = 0;

if (!empty($_POST)) {
    if (empty($_POST['username']) || empty($_POST['pwd'])): {
        ViewsMsg::alert_message("Veuillez remplir tout les champs", "danger");
        exit();
    }
    else: {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['pwd'], PASSWORD_DEFAULT);
        $user = new User($username, "", $password);
        $wrong_username = $user->user_exist() ? $wrong_username : 1;
        
        if (!$user->user_exist()): {
            ViewsMsg::alert_message("Nom d'utilisateur introuvable, veuillez créer un compte", "danger");
            exit();
        }
        else: {
            if (!$user->db_password_verify()): {
                ViewsMsg::alert_message("Mot de passe incorrect, reinitialiser si vous l'avez oublié", "danger");
                exit();
            }
            elseif ($user->active_account() == FALSE): {
                ViewsMsg::alert_message("Veuillez valider votre inscription via le mail reçu, si vous ne l'avez pas recu cliquez ici pour en reçevoir un nouveau", "danger");
                exit();
            }
            else: {
                ViewsMsg::alert_message("Vous êtes désormais connecté, vous allez être redigiré vers l'acceuil", "success");
                $_SESSION['online'] = 1;
                ViewsMsg::index_redirection();
            }
            endif;
        }
        endif;
    }
    endif;
}
else {
    ViewsMsg::alert_message("Page introuvable", "danger");
}