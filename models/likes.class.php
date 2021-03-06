<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/databaseManager.class.php";

class Likes extends databaseManager {

    private $id_img;
    private $img_username;
    private $pdo;

    public function __construct ($id, $user) {
        $this->pdo = $this->databaseConnect();
        $this->id_img = $id;
        $this->img_username = $user;
    }

    public function addLike() {
        date_default_timezone_set('Europe/Paris');
    	$creation_date = date("Y-m-d H:i:s");
        $values = [$this->id_img, $this->img_username, $creation_date];
        $this->insertInto(['id_picture', 'username', 'creation_date'], $values, 'likes');
    }

    public function deleteLike() {
        try {
            echo $this->img_username;
            $query = $this->pdo->prepare("DELETE FROM likes WHERE id_picture = ? AND username = ?");
            $query->execute(array($this->id_img, $this->img_username));
            $query->closeCursor();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getLike() {
        try {
            $query = $this->pdo->prepare("SELECT * FROM `likes` WHERE `id_picture` = ? AND `username` = ?");
            $query->execute(array($this->id_img, $this->img_username));
            $ret = $query->fetch(PDO::FETCH_ASSOC);
            $query->closeCursor();
            return $ret;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteAllLikes() {
        try {
            var_dump($this->id_img);
            $query = $this->pdo->prepare("DELETE FROM `likes` WHERE `id_picture` = ?");
            $query->execute(array($this->id_img));
            $query->closeCursor();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function likesNumber() {
        try {
            $query = $this->pdo->prepare("SELECT `id_like` FROM `likes` WHERE `id_picture` = ?");
            $query->execute(array($this->id_img));
            $likes_number = $query->fetchAll();
            return count($likes_number);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}