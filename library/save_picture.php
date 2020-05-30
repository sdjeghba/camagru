<?php
session_start();
require dirname(__DIR__ ) . '/models/pictures.class.php';

$tmp = $_POST['pic'];
$picture = base64_decode($tmp);
$db = new Pictures("", $_SESSION['username'], $picture);
$id_pic = $db->addPicture();
echo json_encode($id_pic);