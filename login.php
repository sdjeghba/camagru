<?php
require __DIR__ . DIRECTORY_SEPARATOR . "/content/layout/navbar.php";

$cle = md5(microtime(TRUE)*10000);

echo "hello";
var_dump($cle);