<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/databaseManager.class.php";


class User extends databaseManager{

    public    $user_login;
    protected $user_mail;
    protected $user_password;
    protected $user_id;
    protected $pdo;
    private   $only_reset;

    public function __construct(string $user, string $mail, string $pwd) {
        $this->user_login = $user;
        $this->user_mail = $mail;
        $this->user_password = $pwd;
        $this->pdo = $this->db_connect();
        $this->only_reset = 0;
    }

    public function get_user_information(string $user_login, string $value) {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE username = ?');
        $query->execute(array($user_login));
        $row = $query->fetch(PDO::FETCH_OBJ);
        $query->closeCursor();
        return $row->$value;
    }

    private function get_mail_key($login) :string {
        return self::get_user_information($login, "mail_key");
    }

    public function send_validation_mail(?string $mail_key ) {
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

        localhost:8888/controllers/validation_mail_controller.php/?log='.urlencode($this->user_login).'&mail_key='.urlencode($mail_key).'
 
        ---------------
        Ceci est un mail automatique, Merci de ne pas y repondre.';
        mail($recipient, $subject, $message, $mail_header);
        $str = 'localhost:8888/controllers/validation_mail_controller.php/?log='.urlencode($this->user_login).'&mail_key='.urlencode($mail_key);
        echo $str;
    }

    public function send_reset_password_mail() {
        $recipient = "";
        if ($this->only_reset == 1) {
            $recipient = self::get_user_information($this->user_login, "usrmail");
            $tmp_password = md5(microtime(TRUE)*10000);
            $sended_password = password_hash($tmp_password, PASSWORD_DEFAULT);
            $subject= "Reinitialiser votre mot de passe";
            $mail_header = "From : reset_password@camagru.com";
            $message = 'Bonjour, 
            
            Rendez-vous sur la page de reinitialisation de mot passe, remplissez le champs ancien mot de passe avec celui-ci : ' . $tmp_password . 'puis entrez votre nouveau mot de passe!
            
            Reinitialiser mon mot de passe : localhost:8888/controllers/reset_password_controller.php';
            mail($recipient, $subject, $message, $mail_header);
            $query = $this->pdo->prepare("UPDATE users SET userpassword = ? WHERE username = ?");
            $query->execute(array($sended_password, $this->user_login));
            $query->closeCursor();
            $str = 'localhost:8888/controllers/reset_password_controller.php';
            var_dump($tmp_password);
            echo $str;
        }
    }

    public function validation_reset_password () {
        return;
    }

    public function validation_mail(string $login, string $mail_key): int {
        if (self::user_exist() == FALSE)
            return 1;
        if (self::get_mail_key($login) != $mail_key)
            return 2;
        self::update_user_information("active", "1");
        return 0;
    }

    public function db_password_verify() : bool {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE username = ?');
        $query->execute(array($this->user_login));
        $tab = $query->fetchall(PDO::FETCH_OBJ);
        $query->closeCursor();
        foreach ($tab as $row): {
            if ($this->user_login == $row->username) {
                if (password_verify($this->user_password, $row->userpassword)) {
                    return TRUE;
                }
            }
        }
        endforeach;
        return FALSE;
    }

    public function user_exist() : bool {
        return ($this->if_value_exist("username", $this->user_login, "users"));
    }

    public function mail_exist() : bool {
        return ($this->if_value_exist("usrmail", $this->user_mail, "users"));
    }

    public function active_account() : bool {
        return (self::get_user_information($this->user_login, "active") == 1 ? TRUE : FALSE);
    }

    public function sign_in(array $values) {
        $fields = ['username', 'usrmail', 'userpassword', 'mail_key', 'active'];
        $table = 'users';
        $this->insert_into($fields, $values, $table);
    }

    public function user_not_found() :bool {
        if (self::user_exist()) {
            $this->only_reset = 1;
            return TRUE;
        }
        if (self::mail_exist($this->user_login)) {
            $this->only_reset = 2;
            return TRUE;
        }
        return FALSE;
    }

    public function update_user_information(string $field, string $new_value) {
        try {
            $sql = "UPDATE users SET $field = ? WHERE username = ?";
            $query = $this->pdo->prepare($sql);
            $query->execute(array($new_value, $this->user_login));
            $query->closeCursor();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function securePwd($password) :bool {
        var_dump($password);
        if (strtolower($password) === $this->user_login)
            return FALSE;
        if (!(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,20}$#', $password)))
            return FALSE;
        $file = fopen(dirname(__DIR__) . '/dictionnary.txt', 'r');
        $buffer = "";
        if ($file) {
            while (!feof($file) && ($buffer != $password)) {
                $buffer = fgets($file);
            }
            if ($buffer == $password) {
                fclose($file);
                return FALSE;
            }
        }
        return TRUE;
    }

    public static function checkMail(string $email) : bool {
        $reg = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";

        if (preg_match($reg, $email)) {
            $array = explode('@', $email);
            if (checkdnsrr(end($array), 'MX'))
                return TRUE;
            else
                return FALSE;
        }
        return FALSE; 
    }
}