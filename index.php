<?php 
require __DIR__ . DIRECTORY_SEPARATOR . "navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/User.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/HandleDb.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/ViewsMsg.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/App/Form.php";

$mail_error = 0;
$pseudo_error = 0;
$username_error = 0;
$mdp_error = 0;

if (!empty($_POST)) {
    if (empty($_POST['mail']) || empty($_POST['pwd']) || empty($_POST['usrname'])): {
        ViewsMsg::alert_message("Veuillez remplir tout les champs", "danger");
        exit();
    }
    elseif (Form::check_mail(htmlspecialchars($_POST['mail'])) == FALSE): { 
        $mail_error = 1;
    }
    else: {
        $username = htmlspecialchars($_POST['usrname']);
        $usrmail = htmlspecialchars($_POST['mail']);
        $password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $mail_key = md5(microtime(TRUE)*10000);
        $user = new User($username, $usrmail, $password);

        $mdp_error = ($_POST['pwd'] != $_POST['pwd2']) ? 1 : $mdp_error;
        $pseudo_error = $user->user_exist() ? 1 : $pseudo_error;
        $mail_error = $user->mail_exist() ? 2 : $mail_error;

        if (!$mail_error && !$pseudo_error && !$mdp_error) {
            $user->sign_in(['username', 'mail', 'password', 'mail_key', 'active'], [$username, $usrmail, $password, $mail_key, 0], 'users');
            $user->send_mail($mail_key);
            ViewsMsg::alert_message("Félicitation, il ne vous reste plus qu'à valider votre compte via le lien reçu sur votre boite mail", "success");
        }
    }
    endif;
}
?>

<body>
<?php require 'Views/signin.php'; ?>
</body>
<?php require "footer.php"; ?>
