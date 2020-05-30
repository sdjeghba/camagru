<?php
session_start();
require_once dirname(__DIR__ ). "/models/comments.class.php";

$comment = $_POST['comment'];
$id_picture = $_POST['id_picture'];
if ($comment) {
    $query = new Comments($id_picture, $_SESSION['username'], $comment);
    $query->addComment();
}
?>