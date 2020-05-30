<?php

class viewsMsg {
    
    public static function loggedOrNot($online, $session) {
        if (empty($session)) {
            echo <<<HTML
            <div class="alert alert-info text-center" role="alert">
                <h4 class="alert-heading">Woooow</h4>
                Tu veux toi aussi pouvoir prendre des photos avec filtres ?
                <br />
                N'attend plus et rejoins-nous en cliquant ici : <a href="/controllers/sign_in_controller.php" class="alert-link">je m'inscris!</a>
            </div>
HTML;
        }
        else if (!empty($session) && $online == 1) {
            echo <<<HTML
            <div class="alert alert-info text-center" role="alert">
                <h5 class="alert-heading">Tu veux te prendre en photo toi aussi clique sur "GO!" juste ci-dessous !</h4>
                <a href="/camagru.php" class="btn btn-primary btn-lg active" role="button" title="camagru">GO!</a>
            </div>
HTML;
        }
    }

    public static function alertMessage(string $msg, string $type) {
        echo <<<HTML
        <div class="alert alert-$type">$msg</div>
HTML;
    }

    public static function indexRedirection($time) {
        header('Refresh:' . $time . '; url="/index.php"');
        echo <<<HTML
        <a href="/index.php"><i><center>Si la redirection ne s'effectue pas cliquez ici..</center></i></a>
HTML;
    }

    public static function displayPicture(string $img_path) {
        echo <<<HTML
HTML;
    }

    public static function resetDatabase() {
        echo <<<HTML
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="alert alert-danger">La base de donneée existe déjà, voulez vous la reinitialiser ? Toutes les donneées seront perdues..</div>
                    <form action="#" class="form-group">
                        <div class="row justify-content-center">
                            <div class="custom-control custom-radio mx-2 my-2">
                                <input type="radio" id="non" name="customradio" class="custom-control-input" value="no">
                                <label class="custom-control-label" for="non">Non</label>
                            </div>
                            <div class="custom-control custom-radio mx-2 my-2">
                                <input type="radio" id="oui" name="customradio" class="custom-control-input" value="yes">
                                <label class="custom-control-label" for="oui">Oui</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
HTML;
    }
}