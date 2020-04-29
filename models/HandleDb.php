<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config/DbInfos.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/ViewsMsg.php";

/*

    This class handle all database method, called by the setup.php, it create
    the database and tables.
    But not only, the different method offer an object for simply make request for insert, delete..

*/

class HandleDb extends DbInfos {

    private function sql_connect($database_name = ''): PDO {
        try {
            $pdo = new PDO('mysql:host='.$this->host.$database_name, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_OBJ
            ]
        );
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
        return $pdo;
    }

    public function db_connect(): PDO {
        try {
            $pdo = self::sql_connect(";dbname=".$this->db_name);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
            return $pdo;
    }

    public function database_exist($pdo){
        $query = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $query->execute(array($this->db_name));
        return $query->fetch();
    }

    protected function insert_into(array $fields, array $values, string $table) {
        $entries = count($fields) - 1;
        $v = "?";
        for ($i = 0; $i < $entries; $i++) {
            $v .= ",?";
        }
        $str = implode(', ', $fields);
        $pdo = self::db_connect();
        $sql = "INSERT INTO $table ($str) VALUES ($v)";
        $pdo->prepare($sql)->execute($values);
    }

    protected function if_value_exist(string $field, string $to_find, string $table) {
        $sql = "SELECT $field FROM $table";
        $query = $this->pdo->query($sql);
        $array = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($array as $row): {
            if ($to_find == $row->$field) {
                return TRUE;
            }
        }
        endforeach;
        return FALSE;
    }

    private function create_tables(){
        $pdo = self::db_connect();
        $users_table = "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `usrmail` varchar(255) NOT NULL,
            `userpassword` varchar(255) NOT NULL,
            `mail_key` varchar(255) NOT NULL,
            `active` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $pdo->prepare($users_table)->execute();

        $pictures = "CREATE TABLE IF NOT EXISTS `pictures` (
            `id_picture` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(30) NOT NULL,
            `creation_date` DATETIME NOT NULL,
            `picture` LONGBLOB NOT NULL)";
            $pdo->exec($pictures);

        $likes = "CREATE TABLE IF NOT EXISTS `likes` (
            `id_like` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `id_picture` INT UNSIGNED NOT NULL,
            `username` VARCHAR(30) NOT NULL,
            `creation_date` DATETIME NOT NULL)";
            $pdo->exec($likes);
              
        $comments = "CREATE TABLE IF NOT EXISTS `comments` (
        `id_comment` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `id_picture` INT UNSIGNED NOT NULL,
        `comment` VARCHAR(255) NOT NULL,
        `username` VARCHAR(30) NOT NULL,
        `creation_date` DATETIME NOT NULL)";
        $pdo->exec($comments);

    }

    public function create_database(){
        $pdo = self::sql_connect();
        if (!(self::database_exist($pdo)))
        {
            $query = "CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $pdo->prepare($query)->execute();
            self::create_tables();
            if (empty($_GET['customradio'])) {
                ViewsMsg::alert_message("La base de donnée a bien été creée", "success");
            }
        }
        else
        {
            if (!empty($_GET['customradio'])) {
                if ($_GET['customradio'] == "yes"): {
                    $instructions = "DROP DATABASE camagru";
                    $query = $pdo->prepare($instructions)->execute();
                    self::create_database();
                    ViewsMsg::alert_message("La base de donnée a bien été réinitialisé avec succès", "success");
                    header('Refresh:3; url=/index.php');
                }
                else: {
                    header('Location: /index.php');
                }
                endif;
            }
            if (empty($_GET['customradio']))
            {
                echo <<<HTML
                <div class="container my-5">
                    <div class="row justify-content-center">
                        <div class="col-9">
                            <div class="alert alert-danger">La base de donneée existe déjà, voulez vous la reinitialiser ? Toutes les donneées seront perdues..</div>
                            <form action="#" class="form-group">
                                <div class="row justify-content-center">
                                    <div class="custom-control custom-radio mx-2 my-2">
                                        <input type="radio" id="non" name="customradio" class="custom-control-input" value="no">
                                        <label class="custom-control-label" for="non">Non</label>
                                    </div>
                                    <div class="custom-control custom-radio mx-2 my-2">
                                        <input type="radio" id="oui" name="customradio" class="custom-control-input" value="yes">
                                        <label class="custom-control-label" for="oui">Oui</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
HTML;
            }
        }
    }
}