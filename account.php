<?php
require_once __DIR__ . "/content/layout/navbar.php";
require_once __DIR__ . "/models/ViewsMsg.php";
require_once __DIR__ . "/models/User.php";
require_once __DIR__ . "/models/Form.php";
require_once __DIR__ . "/models/HandleDb.php";



$mdp_error = 0;
$pseudo_taken = 0;
$mail_error = 0;
$pseudo_error = 95;
 
if (empty($_SESSION) && empty($_SESSION['username'])): {
    ViewsMsg::alert_message("ERROR: vous n'avez pas accès à cette page", "danger");
}
else: {
    if (!empty($_POST)): {
        if (empty($_POST['username']) && empty($_POST['pwd']) && empty($_POST['newpwd']) && empty($_POST['email']) && empty($_POST['commail'])): {
            ViewsMsg::alert_message("Veuillez remplir au moins un champ", "danger");
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
            
            $mdp_error = htmlspecialchars(($_POST['pwd']) != htmlspecialchars($_POST['newpwd'])) ? 1 : $mdp_error;
            $pseudo_taken = $user->if_value_exist("username", $newusername, "users") ? 1 : $pseudo_taken;
            $mail_error = $user->if_value_exist("usrmail", $newmail, "users") ? 2 : $mail_error;
            $pseudo_error = preg_match("`^[a-z0-9](-?[a-z0-9])*$`", $newusername) ? 1 : 0;
            $pseudo_error = $newusername == "" ? 1 : $pseudo_error;
            if ($newmail)
                $mail_error = Form::check_mail($newmail) == FALSE ? 1 : 0;

            // var_dump($mdp_error);
            // var_dump($pseudo_taken);
            // var_dump($mail_error);
            // var_dump($pseudo_error);

            if (!$mail_error && $pseudo_error && !$mdp_error && !$pseudo_taken) {
                $newmail ? $user->update_user_information("usrmail", $newmail) : 0;
                !empty($notif) && $notif === "yes" ? $user->update_user_information("notif", 1) : 0;
                !empty($notif) && $notif === "no" ? $user->update_user_information("notif", 0) : 0;
                $pwd ? $user->update_user_information("userpassword", $pwd) : 0;
                if ($newusername) {
                    $data = new HandleDb();
                    $data->changeUsername($_SESSION['username'], $newusername);
                    $_SESSION['username'] = $newusername;
                }
                ViewsMsg::alert_message("Vos modifications ont bien été effectuées", "success");

            }
        }
        endif;
    }
    endif;
}
endif;

?>

<body>
    <div class="container-fluid justify-content-center my-3">
        <div class="row my-5 justify-content-center">
            <div class="col-md-5 my-auto">
                <h1 style="text-align:center; font-family:'Comic Sans MS', cursive">BIENVENUE `<?= $_SESSION['username'] ?> `</h1>
                <br>
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                    Modifier mes informations
                    </div>
                    <div class="card-body">
                        <form action="#.php" method="post">
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Nouveau nom d'utilisateur" value="">
                            </div>
                            <?php $pseudo_error == 0 ? ViewsMsg::alert_message("Caractères autorisés : chiffres, lettres et - ", "danger") : 0; ?>
                            <?php $pseudo_taken == 1 ? ViewsMsg::alert_message("Pseudo déjà utilisé choisissez une autre", "danger") : 0; ?>
                            <div class="form-group">
                                <label for="oldpwd">Adresse mail</label>
                                <input type="mail" class="form-control" id="email" name="email" placeholder="Nouvel e-mail" value="">
                            </div>
                            <?php $mail_error == 2 ? ViewsMsg::alert_message("Adresse mail déjà utiliseée choisissez une autre", "danger") : 0; ?>
                            <?php $mail_error == 1 ? ViewsMsg::alert_message("Veuillez entrer une adresse mail valide", "danger") : 0; ?>
                            <div class="form-group">
                                <label for="password">Nouveau mot de passe: </label>
                                <input type="password" class="form-control" id="password" name="pwd" placeholder="Entrez votre mot de passe" value="">
                            </div>
                            <div class="form-group">
                                <label for="newpwd">Confirmez votre mot de passe: </label>
                                <input type="password" class="form-control" id="newpwd" name="newpwd" placeholder="Confirmez votre mot de passe" value="">
                            </div>
                            <?php $mdp_error == 1 ? ViewsMsg::alert_message("Vos deux mots de passes sont differents", "danger") : 0; ?>
                            <div class="form-group">
                                <label for="commail">Activer les notifications :</label>
                                <input type="radio" id="yes" name="commail" value="yes">
                                <label for="img1">Oui</label>
                                <input type="radio" id="no" name="commail" value="no">
                                <label for="img1">Non</label>
                            </div>
                            <div class="text-center">       
                                <button class="btn btn-primary my-4">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>                                        
            </div>
        </div>
    </div>
</body> 
</html>

