<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

$mdp_error = 0;
$pseudo_taken = 0;
$mail_error = 0;
$pseudo_error = 95;
$password_error = 0;
 
if (empty($_SESSION) && empty($_SESSION['username'])): {
    viewsMsg::alertMessage("Vous n'êtes pas autorisé à acceder à cette page", "danger");
    viewsMsg::indexRedirection(3);
    
}
else: {
    if (!empty($_POST)): {
        if (empty($_POST['username']) && empty($_POST['pwd']) && empty($_POST['newpwd']) && empty($_POST['email']) && empty($_POST['commail'])): {
            viewsMsg::alertMessage("Veuillez remplir au moins un champ avant de valider", "danger");
        }
        else: {
            var_dump($_SESSION['username']);
            $username = $_SESSION['username'];
            $user = new User($username, "", "");
            $newusername = htmlspecialchars($_POST['username']);
            $pwd = password_hash(htmlspecialchars($_POST['pwd']), PASSWORD_DEFAULT);
            $newmail = htmlspecialchars($_POST['email']);
            $notif_active = $user->getUserInformation($username, "notif");
            if (!empty($_POST['commail']))
                $notif = htmlspecialchars($_POST['commail']);
            
            $password_error = htmlspecialchars(($_POST['pwd']) != htmlspecialchars($_POST['newpwd'])) ? 1 : $password_error;
            var_dump($pwd);
            $password_error = $_POST['pwd'] && $user->securePwd($_POST['pwd']) == FALSE ? 2 : $password_error; 
            $pseudo_taken = $user->valueExist("username", $newusername, "users") ? 1 : $pseudo_taken;
            $mail_error = $user->valueExist("usrmail", $newmail, "users") ? 2 : $mail_error;
            $pseudo_error = preg_match("`^[a-z0-9](-?[a-z0-9])*$`", $newusername) ? 1 : 0;
            $pseudo_error = $newusername == "" ? 1 : $pseudo_error;
            if ($newmail)
                $mail_error = User::checkMail($newmail) == FALSE ? 1 : 0;

            if (!$mail_error && $pseudo_error && !$password_error && !$pseudo_taken) {
                echo " je suis rentré";
                $newmail ? $user->updateUserInformation("usrmail", $newmail) : 0;
                !empty($notif) && $notif === "yes" ? $user->updateUserInformation("notif", 1) : 0;
                !empty($notif) && $notif === "no" ? $user->updateUserInformation("notif", 0) : 0;
                $pwd ? $user->updateUserInformation("userpassword", $pwd) : 0;
                if ($newusername) {
                    $data = new databaseManager();
                    $data->changeUsername($_SESSION['username'], $newusername);
                    $_SESSION['username'] = $newusername;
                }
                viewsMsg::alertMessage("Vos modifications ont bien été effectuées", "success");
                require_once dirname(__DIR__) . "/views/profil_view.php";
            }
        }
        endif;
    }
    endif;
    require_once dirname(__DIR__) . "/views/profil_view.php";
}
endif;
require_once dirname(__DIR__) . "/content/layout/footer.php";

?>