<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/user.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/databaseManager.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/viewsMsg.class.php";


if (empty($_SESSION['online'])) {
    viewsMsg::alert_message("Page introuvable, vous allez être redirigé..", "danger");
    viewsMsg::index_redirection();
}
else {
    echo "GOOD!";
}