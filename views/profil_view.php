<body>
    <div class="container-fluid justify-content-center my-3">
        <div class="row my-5 justify-content-center">
            <div class="col-md-6 my-auto">
                <h1 style="text-align:center; font-family:'Comic Sans MS', cursive">BIENVENUE</h1>
                <h2 style="text-align:center; font-family:'Comic Sans MS', cursive"><?= $_SESSION['username'] ?></h2>
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
                            <?php $pseudo_error == 0 ? viewsMsg::alertMessage("Caractères autorisés : chiffres, lettres minuscules et - ", "danger") : 0; ?>
                            <?php $pseudo_taken == 1 ? viewsMsg::alertMessage("Pseudo déjà utilisé choisissez une autre", "danger") : 0; ?>
                            <div class="form-group">
                                <label for="oldpwd">Adresse mail</label>
                                <input type="mail" class="form-control" id="email" name="email" placeholder="Nouvel e-mail" value="">
                            </div>
                            <?php $mail_error == 2 ? viewsMsg::alertMessage("Adresse mail déjà utiliseée choisissez une autre", "danger") : 0; ?>
                            <?php $mail_error == 1 ? viewsMsg::alertMessage("Veuillez entrer une adresse mail valide", "danger") : 0; ?>
                            <div class="form-group">
                                <label for="password">Nouveau mot de passe: </label>
                                <input type="password" class="form-control" id="password" name="pwd" placeholder="Entrez votre mot de passe" value="">
                            </div>
                            <?php $password_error == 2 ? viewsMsg::alertMessage("Votre mot de passe doit être différent de votre nom d'utilisateur, contenir entre 5 et 20 charactères, une majuscule, une minuscule, un chiffre et doit être différent de votre pseudo", "danger") : 0; ?>
                            <div class="form-group">
                                <label for="newpwd">Confirmez votre mot de passe: </label>
                                <input type="password" class="form-control" id="newpwd" name="newpwd" placeholder="Confirmez votre mot de passe" value="">
                            </div>
                            <?php $password_error == 1 ? viewsMsg::alertMessage("Vos deux mots de passes sont differents", "danger") : 0; ?>
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