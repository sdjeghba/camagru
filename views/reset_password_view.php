<div class="container-fluid justify-content-center my-3">
    <div class="row my-5 justify-content-center">
        <div class="col-md-5 my-auto">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                Choisissez votre nouveau mot de passe
                </div>
                <div class="card-body">
                    <form action="#.php" method="post">
                    <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="oldpwd">Mot de passe reçu par mail: </label>
                            <input type="password" class="form-control" id="oldpwd" name="oldpwd" placeholder="Mot de passe reçu par mail" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Nouveau mot de passe: </label>
                            <input type="password" class="form-control" id="password" name="pwd" placeholder="Entrez votre mot de passe" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="newpwd">Confirmez votre mot de passe: </label>
                            <input type="password" class="form-control" id="newpwd" name="newpwd" placeholder="Confirmez votre mot de passe" value="" required>
                        </div>
                        <div class="text-center">       
                            <button class="btn btn-primary my-4">Renvoyer</button>
                        </div>
                    </form>
                </div>
            </div>                                        
        </div>
    </div>
</div>