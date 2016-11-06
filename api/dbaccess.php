<?php

  require_once('/dbconnect.php');

  class Dbaccess {

    protected static $db;
    public static $instance;

    private function __construct() {
      self::$db = Dbconnect::getConnection();
      self::$instance = $this;
    }

    public static function getDbAccess() {
      if(!self::$instance) {
        new Dbaccess();
      }

      return self::$instance;
    }
    
    public function getData($query) {
      $statement = self::$db->prepare($query);
      $statement->execute();

      $result_array = array();
      while($result = $statement->fetchObject()) {
        array_push($result_array, $result);
      }

      if(sizeof($result_array) == 0) {
        $result_array = array("Error: " => $statement->errorInfo());
      }

      return json_encode($result_array, JSON_UNESCAPED_UNICODE);

    }

    public function postData($query) {

      $statement = self::$db->prepare($query);
      $statement->execute();

      if($statement->errorCode() === '00000') {
        $result_array = array("Succesfull");
      } else {
        $result_array = array("Error: " => $statement->errorInfo());
      }

      return json_encode($result_array, JSON_UNESCAPED_UNICODE);

    }

  }

?>
