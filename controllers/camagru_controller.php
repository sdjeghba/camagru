<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/User.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/HandleDb.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/ViewsMsg.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "/models/Form.php";


if (empty($_SESSION['online'])) {
    ViewsMsg::alert_message("Page introuvable, vous allez être redirigé..", "danger");
    ViewsMsg::index_redirection();
}
else {
    echo "GOOD!";
}