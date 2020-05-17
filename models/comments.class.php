<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/databaseManager.class.php";

class Comments extends databaseManager {

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

    private function sendCommentMail($recipient) {
        $subject = "Vous avez un nouveau commentaire";
        $mail_header = "From : notifications@camagru.com";
        $message = 'Vous avez un nouveau commentaire sur l\'une de vos photos!

        N\'hésitez pas à vous connecté dès à présent pour voir qui a commenté vos photos!
 
        ---------------
        Ceci est un mail automatique, Merci de ne pas y repondre.';
        mail($recipient, $subject, $message, $mail_header);
        echo "mail envoyé";
        echo $this->comment;
    }

    public function addComment() {
        date_default_timezone_set('Europe/Paris');
        $creation_date = date("Y-m-d H:i:s");
        $fields = ['id_picture', 'comment', 'username', 'creation_date'];
        $values = [$this->picture_id, $this->comment, $this->login, $creation_date];
        $this->insert_into($fields, $values, "comments");
        try {
            $sql = "SELECT `username` FROM `comments` WHERE `id_picture` = ?";
            $query = $this->pdo->prepare($sql);
            $query->execute(array($this->picture_id));
            $ret = $query->fetch(PDO::FETCH_OBJ);
            $query->closeCursor();
            $query = $this->pdo->prepare("SELECT * FROM `users` WHERE `username` = ?");
            $query->execute(array($ret->username));
            $user = $query->fetch(PDO::FETCH_OBJ);
            $query->closeCursor();
            var_dump($user);
            if ($user->notif)
                self::sendCommentMail($user->usrmail);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
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