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

    public static function alert_message(string $msg, string $type) {
        echo <<<HTML
        <div class="alert alert-$type">$msg</div>
HTML;
    }

    public static function index_redirection() {
        header('Refresh: 3; url="/index.php"');
        echo <<<HTML
        <a href="/index.php"><i><center>Si la redirection ne s'effectue pas cliquez ici..</center></i></a>
HTML;
    }

    public static function display_picture(string $img_path) {
        echo <<<HTML
HTML;
    }
}