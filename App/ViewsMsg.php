<?php

class ViewsMsg {
    
    public static function alert_message(string $msg, string $type) {
        echo <<<HTML
        <div class="alert alert-$type">$msg</div>
HTML;
    }
}