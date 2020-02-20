<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/HandleDb.php";


class User extends HandleDB{

    protected $user_login;
    protected $user_mail;
    protected $user_password;
    protected $user_id;
    protected $pdo;

    public function __construct(string $user, string $mail, string $pwd) {
        $this->user_login = $user;
        $this->user_mail = $mail;
        $this->user_password = $pwd;
        $this->pdo = $this->db_connect();
    }

    public function get_mail_key($login) :string {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute(array($login));
        $userbox = $query->fetch(PDO::FETCH_OBJ);
        return $userbox->mail_key;
    }

    public function send_mail(?string $mail_key) {
        if ($mail_key == NULL) {
            $mail_key = self::get_mail_key($this->user_login);
        }
        $recipient = $this->user_mail;
        $active = 0;
        $subject = "Activer votre compte";
        $mail_header = "From : inscription@camagru.com";
        $message = 'Bienvenu sur Camagru!
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.

        localhost:8888/controllers/validation_mail.php/?log='.urlencode($this->user_login).'&mail_key='.urlencode($mail_key).'
 
        ---------------
        Ceci est un mail automatique, Merci de ne pas y repondre.';
        mail($recipient, $subject, $message, $mail_header);
        $str = 'localhost:8888/controllers/validation_mail.php/?log='.urlencode($this->user_login).'&mail_key='.urlencode($mail_key);
        echo $str;

    }

    public function validation_mail(string $login, string $mail_key): int {
        if ($this->user_exist() == FALSE)
            return 1;
        if (self::get_mail_key($login) != $mail_key)
            return 2;
        $query = $this->pdo->prepare("UPDATE users SET active = '1' WHERE username = ?");
        $query->execute(array($login));
        return 0;
    }

    public function password_verify() : bool {
        if ($this->user_exist() == FALSE)
            return FALSE;
        $sql = $this->pdo->query('SELECT * FROM users');
        $tab = $sql->fetchall(PDO::FETCH_OBJ);
        foreach ($tab as $row): {
            if ($this->user_login == $row->username) {
                if (password_verify($this->user_password, $row->password)) {
                    return TRUE;
                }
            }
        }
        endforeach;
        return FALSE;
    }

    public function user_exist() : bool {
        $sql = $this->pdo->query('SELECT username FROM users');
        $tab = $sql->fetchall(PDO::FETCH_OBJ);
        foreach ($tab as $row): {
            if ($this->user_login == $row->username)
                return TRUE;
        }
        endforeach;
        return FALSE;
    }

    public function mail_exist() : bool {
        $sql = $this->pdo->query('SELECT usrmail FROM users');
        $tab = $sql->fetchall(PDO::FETCH_OBJ);
        foreach ($tab as $row): {
            if ($this->user_mail == $row->usrmail)
                return TRUE;
        }
        endforeach;
        return FALSE;
    }

    public function sign_in(array $fields, array $values, string $table) {
        $this->insert_into($fields, $values, $table);
    }
}