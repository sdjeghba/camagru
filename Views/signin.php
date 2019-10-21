<div class="container-fluid justify-content-center">
    <div class="row my-5">
        <div class="col-md-3 my-auto">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                Inscription
                </div>
                <div class="card-body">
                    <p class="font-italic">Tu n'as pas de compte et tu souhaites toi aussi prendre des photos avec filtres ? Inscris toi en quelques secondes!</p>
                    <br/>
                    <form action="#.php" method="post">
                    <div class="form-group">
                            <label for="username">Non utilisateur : </label>
                            <input type="text" class="form-control" id="username" name="usrname" placeholder="Choisir un nom d'utilisateur" required>
                        </div>
                        <?php $pseudo_error == 1 ? ViewsMsg::alert_message("Pseudo déjà utiliseé choisissez une autre", "danger") : 0; ?>
                        <div class="form-group">
                            <label for="mail1">Adresse mail : </label>
                            <input type="email" class="form-control" id="mail1" name="mail" placeholder="Entrez votre email" required>
                        </div>
                        <?php $mail_error == 2 ? ViewsMsg::alert_message("Adresse mail déjà utiliseée choisissez une autre ou bien cliquer sur mot de passe oublié dans la barre de navigation", "danger") : 0; ?>
                        <?php $mail_error == 1 ? ViewsMsg::alert_message("Veuillez entrer une adresse mail valide", "danger") : 0; ?>
                        <div class="form-group">
                            <label for="password">Mot de passe : </label>
                            <input type="password" class="form-control" id="password" name="pwd" placeholder="Entrez votre mot de passe" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Confirmer votre mot de passe : </label>
                            <input type="password" class="form-control" id="password2" name="pwd2" placeholder="Confirmez votre mot de passe" required>
                        </div>
                        <?php $mdp_error == 1 ? ViewsMsg::alert_message("Vos deux mots de passes sont differents", "danger") : 0; ?>
                        <div class="text-center">       
                            <button class="btn btn-primary my-4">S'inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>