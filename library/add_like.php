<?php
session_start();

require_once dirname(__DIR__ ) . "/models/likes.class.php";
$id_picture = $_GET['id_picture'];
$db = new Likes($id_picture, $_SESSION['username']);
$db->addLike();