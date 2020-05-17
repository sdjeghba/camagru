<?php
session_start();

$tmp = $_POST['pic'];
$picture = base64_decode($tmp);
require __DIR__ . '/models/pictures.class.php';
$db = new Pictures("", $_SESSION['username'], $picture);
$id_pic = $db->addPicture();
echo json_encode($id_pic);