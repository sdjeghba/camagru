<?php
session_start();
require_once dirname(__DIR__ ) . DIRECTORY_SEPARATOR ."models/likes.class.php";

$id_picture = $_GET['id_picture'];
$req = new Likes($id_picture, $_SESSION['username']);
$req->deleteLike();