<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "App/HandleDb.php";


class User extends HandleDB{

    protected $user_login;
    protected $user_password;
    protected $user_id;
    protected $pdo;

    public function __construct(string $user, string $pwd) {
        $this->user_login = $user;
        $this->user_password = $pwd;
        $this->pdo = $this->db_connect();
    }

    public function validation_mail(string $login, string $mail_key): int {
        if ($this->user_exist() == FALSE) {
            return 1;
        }
        $sql = $this->pdo->query("SELECT * FROM users WHERE username = '{$login}'");
        $userbox = $sql->fetch(PDO::FETCH_OBJ);
        if ($userbox->mail_key != $mail_key) {
            return 2;
        }
        return 0;;
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

    public function user_exist()  : bool {
        $sql = $this->pdo->query('SELECT username FROM users');
        $tab = $sql->fetchall(PDO::FETCH_OBJ);
        foreach ($tab as $row): {
            if ($this->user_login == $row->username)
                return TRUE;
        }
        endforeach;
        return FALSE;
    }

    public function sign_in(array $fields, array $values, string $table) : bool {
        if ($this->user_exist() == TRUE)
            return FALSE;
        var_dump($fields);
        $this->insert_into($fields, $values, $table);
        return TRUE;
    }
}