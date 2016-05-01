<?php
/**
* Coding Pirates Team-inator
* Used to generate teams at Coding Pirates Game Jam 2015
*/

class DB{
  function query($sql,$values=false) {
    $db = $this->connect();
    $query = $db->prepare($sql);
    if($values != false) {
      foreach($values as list($name,$value)) {
        $query->bindValue($name, $value);
      }
    }
    $query->execute();
    if($query->rowCount() > 0) {
      $results = $query->fetchAll();
      return $results;
    }
  }

  // Count
  function count($sql,$values=false) {
    $db = $this->connect();
    $query = $db->prepare($sql);
    if($values != false) {
      foreach($values as list($name,$value)) {
        $query->bindValue($name, $value);
      }
    }
    $query->execute();
    return $query->rowCount();
  }

  // Connect to db
  private function connect() {
    $dsn = "mysql:dbname=teaminator;host=127.0.0.1";
    $user = "teaminator";
    $password = "password";

    try {
      $db = new PDO($dsn,$user,$password);
    } catch(PDOException $e) {
      echo "Databasefejl " . $e->getMessage();
    }
    return $db;
  }
}
?>
