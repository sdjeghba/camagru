<?php
session_start();
require_once __DIR__ . "/models/comments.php";

$comment = $_POST['comment'];
$id_picture = $_POST['id_picture'];
echo "good";
if ($comment) {
    $query = new Comments($id_picture, $_SESSION['username'], $comment);
    $query->addComment();
}
?>