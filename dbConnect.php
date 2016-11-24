<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
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
    // first, get config file
    if(file_exists("config.php")) {
      include_once("config.php");
    } else {
      die("No config file");
    }
    $config = new config;
    $dsn = "mysql:dbname=" . $config->get_db() . ";host=" . $config->get_host() . ";charset=utf8mb4";
    $user = $config->get_user();
    $password = $config->get_pass();

    try {
      $db = new PDO($dsn,$user,$password);
    } catch(PDOException $e) {
      echo "Databasefejl " . $e->getMessage();
    }
    return $db;
  }
}
?>
