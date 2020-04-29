<?php
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR ."models/likes.php";

$id_picture = $_GET['id_picture'];
$req = new Likes($id_picture, $_SESSION['username']);
$req->deleteLike();