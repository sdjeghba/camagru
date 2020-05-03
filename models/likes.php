<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/HandleDb.php";

class Likes extends HandleDb {

    private $id_img;
    private $img_username;
    private $pdo;

    public function __construct ($id, $user) {
        $this->pdo = $this->db_connect();
        $this->id_img = $id;
        $this->img_username = $user;
    }

    public function addLike() {
        date_default_timezone_set('Europe/Paris');
    	$creation_date = date("Y-m-d H:i:s");
        $values = [$this->id_img, $this->img_username, $creation_date];
        $this->insert_into(['id_picture', 'username', 'creation_date'], $values, 'likes');
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

    public function changeUsername(string $oldusername, $newusername) {
        try {
            $sql = "UPDATE likes SET `username` = ? WHERE username = ?";
            $query = $this->pdo->prepare($sql);
            $query->execute(array($newusername, $oldusername));
            $query->closeCursor();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}