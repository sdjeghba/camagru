<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/viewsMsg.class.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config/database.php";

/*

    This class handle all database method, called by the setup.php, it create
    the database and tables.
    But not only, the different method offer an object for simply make request for insert, delete..

*/

class databaseManager extends databaseInfo {

    private $db_name = "camagru";

    private function sqlConnect($database_name = ''): PDO {
        try {
            $pdo = new PDO($this->DB_DSN.$database_name, $this->DB_USER, $this->DB_PASSWORD, [
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

    public function databaseConnect(): PDO {
        try {
            $pdo = self::sqlConnect();
            if (!(self::databaseExist($pdo)))
                self::createDatabase();
            $pdo = self::sqlConnect(";dbname=".$this->db_name);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
        return $pdo;
    }

    public function databaseExist($pdo){

        $query = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $query->execute(array($this->db_name));
        $tmp = $query->fetch();
        return $tmp;
    }

    protected function insertInto(array $fields, array $values, string $table) {
        $entries = count($fields) - 1;
        $v = "?";
        for ($i = 0; $i < $entries; $i++) {
            $v .= ",?";
        }
        $str = implode(', ', $fields);
        $pdo = self::databaseConnect();
        $sql = "INSERT INTO $table ($str) VALUES ($v)";
        $pdo->prepare($sql)->execute($values);
    }

    public function valueExist(string $field, string $to_find, string $table) {
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

    public function changeUsername(string $oldusername, string $newusername) {
        try {
            var_dump($oldusername);
            var_dump($newusername);
            $pdo = self::databaseConnect();
            $sql_pictures = "UPDATE `pictures` SET `username` = ? WHERE `username` = ?";
            $query = $pdo->prepare($sql_pictures);
            $query->execute(array($newusername, $oldusername));
            $query->closeCursor();
            $sql_likes = "UPDATE `likes` SET `username` = ? WHERE `username` = ?";
            $query = $pdo->prepare($sql_likes);
            $query->execute(array($newusername, $oldusername));
            $query->closeCursor();
            $sql_comments = "UPDATE `comments` SET `username` = ? WHERE `username` = ?";
            $query = $pdo->prepare($sql_comments);
            $query->execute(array($newusername, $oldusername));
            $query->closeCursor();
            $sql_users = "UPDATE `users` SET `username` = ? WHERE `username` = ?";
            $query = $pdo->prepare($sql_users);
            $query->execute(array($newusername, $oldusername));
            $query->closeCursor();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function createTables(){
        $pdo = self::databaseConnect();
        $users_table = "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `usrmail` varchar(255) NOT NULL,
            `userpassword` varchar(255) NOT NULL,
            `mail_key` varchar(255) NOT NULL,
            `active` int(11) NOT NULL,
            `notif` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $pdo->prepare($users_table)->execute();

        $pictures = "CREATE TABLE IF NOT EXISTS `pictures` (
            `id_picture` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(30) NOT NULL,
            `creation_date` DOUBLE NOT NULL,
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

    public function createDatabase(){
        $pdo = self::sqlConnect();
        if (!(self::databaseExist($pdo))): {
            $query = "CREATE DATABASE IF NOT EXISTS $this->db_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $pdo->prepare($query)->execute();
            self::createTables();
            if (empty($_GET['customradio']) && ($_SERVER['PHP_SELF'] == "/config/setup.php")) {
                viewsMsg::alertMessage("La base de donnée a bien été creée", "success");
            }
        }
        else :{
            if (!empty($_GET['customradio'])) {
                if ($_GET['customradio'] == "yes"): {
                    $instructions = "DROP DATABASE " . $this->db_name;
                    $query = $pdo->prepare($instructions)->execute();
                    self::createDatabase();
                    viewsMsg::alertMessage("La base de donnée a bien été réinitialisé avec succès", "success");
                    header('Refresh:3; url=/index.php');
                }
                else: {
                    header('Location: /index.php');
                }
                endif;
            }
            if (empty($_GET['customradio']))
                viewsMsg::resetDatabase();
        }
        endif;
    }
}
