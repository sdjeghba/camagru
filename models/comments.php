<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/HandleDb.php";

class Comments extends HandleDb {
    
    private $picture_id;
    private $comment;
    private $login;
    private $pdo;

    public function __construct($id_img, $user, $comment) {
        $this->picture_id = $id_img;
        $this->login = $user;
        $this->comment = $comment;
        $this->pdo = $this->db_connect();
    }

    public function getComments() {
        try {
            $query = $this->pdo->prepare("SELECT * FROM `comments` WHERE `id_picture` = ? ORDER BY `creation_date` DESC");
            $query->execute(array($this->picture_id));
            $ret = $query->fetchAll(PDO::FETCH_OBJ);
            $query->closeCursor();
            return $ret;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addComment() {
        date_default_timezone_set('Europe/Paris');
        $creation_date = date("Y-m-d H:i:s");
        $fields = ['id_picture', 'comment', 'username', 'creation_date'];
        $values = [$this->picture_id, $this->comment, $this->login, $creation_date];
        $this->insert_into($fields, $values, "comments");
        //sendmail après à faire
    }

    public function getCommentsNumber() {
        return count(self::getComments());
    }

    public function deleteAllComments() {
        try {
            $query = $this->pdo->prepare("DELETE FROM `comments` WHERE `id_picture` = ?");
            $query->execute(array($this->picture_id));
            $query->closeCursor();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}