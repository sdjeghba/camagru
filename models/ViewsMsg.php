<?php

class ViewsMsg {
    
    public static function alert_message(string $msg, string $type) {
        echo <<<HTML
        <div class="alert alert-$type">$msg</div>
HTML;
    }

    public static function index_redirection() {
        header('Refresh: 4; url="/index.php"');
        echo <<<HTML
        <a href="/index.php"><i><center>Si la redirection ne s'effectue pas cliquez ici..</center></i></a>
HTML;
    }
}