<?php

namespace app\db;
use PDO;

class Db {

  protected $db;

  public function __construct() {
    $config = require 'app/config/db.php';
    $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function query($sql, $parameters = []) {
    $stmt = $this->db->prepare($sql);
    if(!empty($parameters)) {
      foreach ($parameters  as $key => $value) {
        $stmt->bindValue(':'.$key, $value);
      }
    }
    $stmt->execute();
    return $stmt;
  }

  public function row($sql, $parameters = []) {
    $result = $this->query($sql, $parameters);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function column($sql, $parameters = []) {
    $result = $this->query($sql, $parameters);
    return $result->fetchColumn();
  }

}


?>
