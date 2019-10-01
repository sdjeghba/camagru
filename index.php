<?php 
require __DIR__ . DIRECTORY_SEPARATOR . "navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/User.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/HandleDb.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./App/ViewsMsg.php";

//var_dump($_POST);
$mail_error = 0;
if (!empty($_POST)) {
    if (empty($_POST['mail']) || empty($_POST['pwd'])): {
        ViewsMsg::alert_message("E-mail ou mot de passe manquant", "danger");
    }
    else: {
        $username = htmlentities($_POST['mail']);
        $password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $mail_key = md5(microtime(TRUE)*10000);
        $active = 0;

        $recipient = $username;
        $subject = "Activer votre compte";
        $mail_header = "From : inscription@camagru.com";
        $message = 'Bienvenu sur Camagru!
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.

        localhost:8888/validation_mail.php/?log='.urlencode($username).'&mail_key='.urlencode($mail_key).'
 
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        var_dump(mail($recipient, $subject, $message, $mail_header));
        $user = new User($username, $password);
        //var_dump($user);
        if ($user->sign_in(['username', 'password', 'mail_key', 'active'], [$username, $password, $mail_key, $active], 'users') == FALSE)
            $mail_error = 1;
        else 
            ViewsMsg::alert_message("we're here", "success");
    }
    endif;
}
else {
    ViewsMsg::alert_message("chelou", "danger");
}
?>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-3 mx-3 my-4">
                <div class="card text-center border-primary mb-3 my-4" style="width:18rem;">
                    <div class="card-header bg-primary text-white">Inscription</div>
                    <div class="card-body justify-content-center">
                        <p class="font-italic">Tu n'a pas de compte et tu souhaites toi aussi prendres des photos avec filtres ? Inscris toi en quelques secondes!</p> 
                    </div>
                    <form action="#.php" method="post">
                        <div class="form-group">
                            <?php $mail_error ? ViewsMsg::alert_message("Adresse mail déjà utilisé veuillez en choisir une autre ou bien cliquer sur mot de passe oublié dans la barre de navigation", "danger") : 0; ?>
                            <label for="mail1">Adresse mail:</label>
                            <input type="email" class="form-control" id="mail1" name="mail" placeholder="Entrez votre email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="pwd" placeholder="Entrez votre mot de passe" required>
                        </div>
                        <button class="btn btn-primary my-4">S'inscrire</button>
                    </form>
                </div>        
            </div>
            <div class="col-8 mx-3 my-4">
                <h2 style="text-align:center">Vos dernières photos prises</h2>
                Two.
            </div>
        </div>
    </div>
</body>

<?php require "footer.php"; ?>