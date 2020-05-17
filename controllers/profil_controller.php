<?php
require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/models/viewsMsg.class.php";
require_once dirname(__DIR__) . "/models/user.class.php";
require_once dirname(__DIR__) . "/models/databaseManager.class.php";

$mdp_error = 0;
$pseudo_taken = 0;
$mail_error = 0;
$pseudo_error = 95;
$password_error = 0;
 
if (empty($_SESSION) && empty($_SESSION['username'])): {
    viewsMsg::alert_message("ERROR: vous n'avez pas accès à cette page", "danger");
}
else: {
    if (!empty($_POST)): {
        if (empty($_POST['username']) && empty($_POST['pwd']) && empty($_POST['newpwd']) && empty($_POST['email']) && empty($_POST['commail'])): {
            viewsMsg::alert_message("Veuillez remplir au moins un champ avant de valider", "danger");
        }
        else: {
            var_dump($_SESSION['username']);
            $username = $_SESSION['username'];
            $user = new User($username, "", "");
            $newusername = htmlspecialchars($_POST['username']);
            $pwd = password_hash(htmlspecialchars($_POST['pwd']), PASSWORD_DEFAULT);
            $newmail = htmlspecialchars($_POST['email']);
            $notif_active = $user->get_user_information($username, "notif");
            if (!empty($_POST['commail']))
                $notif = htmlspecialchars($_POST['commail']);
            
            $password_error = htmlspecialchars(($_POST['pwd']) != htmlspecialchars($_POST['newpwd'])) ? 1 : $password_error;
            var_dump($pwd);
            $password_error = $_POST['pwd'] && $user->securePwd($_POST['pwd']) == FALSE ? 2 : $password_error; 
            $pseudo_taken = $user->if_value_exist("username", $newusername, "users") ? 1 : $pseudo_taken;
            $mail_error = $user->if_value_exist("usrmail", $newmail, "users") ? 2 : $mail_error;
            $pseudo_error = preg_match("`^[a-z0-9](-?[a-z0-9])*$`", $newusername) ? 1 : 0;
            $pseudo_error = $newusername == "" ? 1 : $pseudo_error;
            if ($newmail)
                $mail_error = User::checkMail($newmail) == FALSE ? 1 : 0;
            // var_dump($password_error);
            // var_dump($pseudo_taken);
            // var_dump($mail_error);
            // var_dump($pseudo_error);

            if (!$mail_error && $pseudo_error && !$password_error && !$pseudo_taken) {
                echo " je suis rentré";
                $newmail ? $user->update_user_information("usrmail", $newmail) : 0;
                !empty($notif) && $notif === "yes" ? $user->update_user_information("notif", 1) : 0;
                !empty($notif) && $notif === "no" ? $user->update_user_information("notif", 0) : 0;
                $pwd ? $user->update_user_information("userpassword", $pwd) : 0;
                if ($newusername) {
                    $data = new databaseManager();
                    $data->changeUsername($_SESSION['username'], $newusername);
                    $_SESSION['username'] = $newusername;
                }
                viewsMsg::alert_message("Vos modifications ont bien été effectuées", "success");
            }
        }
        endif;
    }
    endif;
}
endif;
require_once dirname(__DIR__) . "/views/profil_view.php";
?>