<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

$old_mdp_error = 0;
$new_mdp_error = 0;
$username_not_found = 0;
$success = 0;

if (empty($_SESSION['online'])): {
    if (!empty($_POST)) {
        if (empty($_POST['pwd']) || empty($_POST['oldpwd']) || empty($_POST['newpwd'])): {
            viewsMsg::alertMessage("Veuillez remplir tout les champs", "danger");
            exit();
        }
        else: {
            $username = htmlspecialchars($_POST['username']);
            $old_password = htmlspecialchars($_POST['oldpwd']);
            $new_password = password_hash(htmlspecialchars($_POST['newpwd']), PASSWORD_DEFAULT);
            $user = new User($username, "", $old_password);
            
            $old_mdp_error = $user->dbPasswordVerify($old_password) == FALSE ? 1 : $old_mdp_error;
            $new_mdp_error = $_POST['pwd'] && $user->securePwd($_POST['pwd']) == FALSE ? 2 : $new_mdp_error; 
            $new_mdp_error = htmlspecialchars($_POST['pwd']) != htmlspecialchars($_POST['newpwd']) ? 1 : $new_mdp_error;
            $username_not_found = $user->userExist() == FALSE ? 1 : $username_not_found;

            if (!$old_mdp_error && !$new_mdp_error && !$username_not_found) {
                $user->updateUserInformation("userpassword", $new_password);
                viewsMsg::alertMessage("Félicitation votre mot de passe a bien été changé", "success");
                viewsMsg::indexRedirection(3);
                $success = 1;
            }
        }
        endif;
    }
    if (!$success) {
        require_once dirname(__DIR__) . "/views/reset_password_view.php";
    }
}
else: {
    viewsMsg::alertMessage("Page introuvable, vous allez être redirigé..", "danger");
    viewsMsg::indexRedirection(3);
}
endif;


