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
        $this->pdo = $this->databaseConnect();
        $this->only_reset = 0;
    }

    public function getUserInformation(string $user_login, string $value) {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE username = ?');
        $query->execute(array($user_login));
        $row = $query->fetch(PDO::FETCH_OBJ);
        $query->closeCursor();
        return $row->$value;
    }

    private function getMailKey($login) :string {
        return self::getUserInformation($login, "mail_key");
    }

    public function sendValidationMail(?string $mail_key ) {
        if ($mail_key == NULL) {
            $mail_key = self::getMailKey($this->user_login);
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

    public function sendResetPasswordMail() {
        $recipient = "";
        if ($this->only_reset == 1) {
            $recipient = self::getUserInformation($this->user_login, "usrmail");
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

    public function validationResetPassword () {
        return;
    }

    public function validationMail(string $login, string $mail_key): int {
        if (self::userExist() == FALSE)
            return 1;
        if (self::getMailKey($login) != $mail_key)
            return 2;
        self::updateUserInformation("active", "1");
        return 0;
    }

    public function dbPasswordVerify() : bool {
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

    public function userExist() : bool {
        return ($this->valueExist("username", $this->user_login, "users"));
    }

    public function mailExist() : bool {
        return ($this->valueExist("usrmail", $this->user_mail, "users"));
    }

    public function activeAccount() : bool {
        return (self::getUserInformation($this->user_login, "active") == 1 ? TRUE : FALSE);
    }

    public function signIn(array $values) {
        $fields = ['username', 'usrmail', 'userpassword', 'mail_key', 'active', 'notif'];
        $table = 'users';
        $this->insertInto($fields, $values, $table);
    }

    public function userNotFound() :bool {
        if (self::userExist()) {
            $this->only_reset = 1;
            return TRUE;
        }
        if (self::mailExist($this->user_login)) {
            $this->only_reset = 2;
            return TRUE;
        }
        return FALSE;
    }

    public function updateUserInformation(string $field, string $new_value) {
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
        if (strtolower($password) === $this->user_login)
            return FALSE;
        if (!(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{5,20}$#', $password)))
            return FALSE;
        $file = fopen(dirname(__DIR__) . '/content/dictionnary.txt', 'r');
        $minpassword = strtolower($password);
        $buffer = "";
        if ($file) {
            while (!feof($file) && ($buffer != $minpassword)) {
                $buffer = trim(fgets($file));
                if ($buffer == $minpassword) {
                    fclose($file);
                    return FALSE;
                }
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