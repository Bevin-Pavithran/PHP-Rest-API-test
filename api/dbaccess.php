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
    
    public function getData($query,$fields) {
      try {

        $statement = self::$db->prepare($query);
        $statement->execute($fields);

        $result_array = array();
        while($result = $statement->fetchObject()) {
          array_push($result_array, $result);
        }

        if(sizeof($result_array) == 0) {
          throw new Exception("Data not found");
        }

        return $result_array;

      } catch(PDOException $e) {
        throw new Exception("Database query error");
      } catch(Exception $e) {
        throw new Exception($e->getMessage());
      }

    }

    public function postData($query,$fields) {

      try {
        $statement = self::$db->prepare($query);
        $statement->execute($fields);

        return "successfull";

      } catch(PDOException $e) {
        throw new Exception("Database query error");
      }

    }

  }

?>
