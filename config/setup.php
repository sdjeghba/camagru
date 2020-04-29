<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "/content/layout/navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./models/HandleDb.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config/DbInfos.php";

$db = new HandleDb();
$db->create_database();
// require_once dirname(__DIR__) . "/controllers/logout.php";
session_destroy();
// header ("Location: /index.php");

?>