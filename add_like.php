<?php
session_start();

require_once __DIR__ . "/models/likes.php";
$id_picture = $_GET['id_picture'];
$db = new Likes($id_picture, $_SESSION['username']);
$db->addLike();