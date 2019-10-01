<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "navbar.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR ."./App/HandleDb.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config/DbInfos.php";

$db = new HandleDb();
$db->create_database();

?>