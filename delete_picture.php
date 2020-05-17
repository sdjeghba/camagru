<?php
session_start();

require_once __DIR__ . '/models/pictures.class.php';
require_once __DIR__ . '/models/likes.class.php';
require_once __DIR__ . '/models/comments.class.php';

$id_pic = $_GET['id_pic'];
$db = new Pictures($id_pic, "", $_SESSION['username']);
$db->deletePicture();
$like = new Likes($id_pic, "");
$like->deleteAllLikes();
$comment = new Comments($id_pic, "", "");
$comment->deleteAllComments();