<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/User.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/HandleDb.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/ViewsMsg.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "/models/Form.php";

$old_mdp_error = 0;
$new_mdp_error = 0;
$username_not_found = 0;

if (empty($_SESSION['online'])): {
    if (!empty($_POST)) {
        if (empty($_POST['pwd']) || empty($_POST['oldpwd']) || empty($_POST['newpwd'])): {
            ViewsMsg::alert_message("Veuillez remplir tout les champs", "danger");
            exit();
        }
        else: {
            $username = htmlspecialchars($_POST['username']);
            $old_password = htmlspecialchars($_POST['oldpwd']);
            $new_password = password_hash(htmlspecialchars($_POST['newpwd']), PASSWORD_DEFAULT);
            $user = new User($username, "", $old_password);
            
            $old_mdp_error = $user->db_password_verify($old_password) ? 1 : $old_mdp_error;
            $new_mdp_error = htmlspecialchars($_POST['pwd']) === htmlspecialchars($_POST['newpwd']) ? 1 : $new_mdp_error;
            $username_not_found = $user->user_exist() ? 1 : $username_not_found;

            if ($old_mdp_error && $new_mdp_error && $username_not_found) {
                $user->update_user_information("userpassword", $new_password);
                ViewsMsg::alert_message("Félicitation votre mot de passe a bien été changé", "success");
            }
            else {
                ViewsMsg::alert_message("ERROR", "danger");
                echo "------------------";
                var_dump($old_mdp_error);
                var_dump($new_mdp_error);
                var_dump($username_not_found);
                echo "------------------";
            }
        }
        endif;
    }
    if (empty($success)) {
        require_once dirname(__DIR__) . "/views/reset_password_view.php";
    }
}
else: {
    ViewsMsg::alert_message("Page introuvable, vous allez être redirigé..", "danger");
    ViewsMsg::index_redirection();
}
endif;


