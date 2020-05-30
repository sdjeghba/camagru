<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/databaseManager.class.php";


$db = new databaseManager();
$db->createDatabase();
// require_once dirname(__DIR__) . "/library/logout.php";
session_destroy();
// header ("Location: /index.php");

?>