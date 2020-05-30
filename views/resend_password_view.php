<div class="container-fluid justify-content-center my-3">
    <div class="row my-5 justify-content-center">
        <div class="col-md-6 my-auto">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                Reinitialiser son mot de passe
                </div>
                <div class="card-body">
                    <form action="#.php" method="post">
                    <div class="form-group">
                            <label for="username">Non utilisateur ou adresse mail : </label>
                            <input type="text" class="form-control" id="username" name="usrname" placeholder="Choisir un nom d'utilisateur" value="" required>
                        </div>
                        <?php $pseudo_error == 0 ? viewsMsg::alertMessage("Adresse mail ou pseudo inconnu", "danger") : 0; ?>
                        <div class="text-center">       
                            <button class="btn btn-primary my-4">Reinitialiser</button>
                        </div>
                    </form>
                </div>
            </div>                                        
        </div>
    </div>
</div>