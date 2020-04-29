<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/HandleDb.php";

class Pictures extends HandleDb {

  protected $img_owner;
  protected $pdo;
  protected $img;
  protected $id_picture;

  public function __construct($id_picture, string $user_name, $picture) {
    $this->img_owner = htmlspecialchars($user_name);
    $this->img = $picture;
    $this->id_picture = $id_picture;
    $this->pdo = $this->db_connect();
  }

  public function addPicture() {
    date_default_timezone_set('Europe/Paris');
    $creation_date = date("Y-m-d H:i:s");
    $fields = ["username", "creation_date", "picture"];
    $values = [$this->img_owner,$creation_date, $this->img];
    $this->insert_into($fields, $values, "pictures");
    try {
      $query = $this->pdo->query("SELECT `id_picture` FROM `pictures` WHERE `username` = '" . $this->img_owner . "' AND `creation_date` = '" . $creation_date . "' ");
      $ret = $query->fetch(PDO::FETCH_ASSOC);
      $query->closeCursor();
      return $ret;
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
  }

  public function getPicturesConstraints($limit, bool $index, $start, bool $user) {
    if ($user == TRUE && $this->img_owner) {
      $sql = "SELECT * FROM `pictures` WHERE `username` = ? ORDER BY `creation_date` DESC";
      $sql = $index && $limit ? $sql . " LIMIT $start, $limit" : $sql;
      $sql = $limit && !$index ? $sql." LIMIT $limit" : $sql;
      try {
        $query = $this->pdo->prepare($sql);
        $query->execute(array($this->img_owner));
        $tab = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $tab;
      }
      catch (PDOException $e) {
        die($e->getMessage());
      }
    }
    else {
      $sql = "SELECT * FROM `pictures` ORDER BY `creation_date` DESC";
      $sql = $index == TRUE ? $sql . " LIMIT $start, $limit" : $sql;
      $sql = $limit && !$index ? $sql . " LIMIT $limit" : $sql;
      try {
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $tab = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $tab;
      }
      catch (PDOException $e) {
        die($e->getMessage());
      }
    }
  }

  public function getAllPictures() {
    try {
      $sql =  "SELECT * FROM `pictures` ORDER BY `creation_date` DESC";
      $query = $this->pdo->prepare($sql);
      $query->execute();
      $ret = $query->fetchAll(PDO::FETCH_ASSOC);
      $query->closeCursor();
      return $ret;
    }
    catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function getAllUserPictures() {
    try {
      $sql =  "SELECT * FROM `pictures` WHERE `username` = ? ORDER BY `creation_date` DESC";
      $query = $this->pdo->prepare($sql);
      $query->execute(array($this->img_owner));
      $ret = $query->fetchAll(PDO::FETCH_ASSOC);
      $query->closeCursor();
      return $ret;
    }
    catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function getPicturesNumber() {
    return count(self::getAllPictures());
  }

  public function getUserPicturesNumber() {
    return count(self::getAllUserPictures());
  }

  public function deletePicture() {
    try {
      $query = $this->pdo->prepare("DELETE FROM `pictures` WHERE `id_picture` = ?");
      $query->execute(array($this->id_picture));
      $query->closeCursor();

    }
    catch (PDOException $e){
      die($e->getMessage());
    }
  }
}