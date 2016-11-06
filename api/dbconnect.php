<?php

  class Dbconnect {

    protected static $db;

    private function __construct() {

      try {
        define("root",$_SERVER['DOCUMENT_ROOT']);

        $config = parse_ini_file(root."/restapi/config.ini");

        self::$db = new PDO( "mysql:host={$config['db_host']}; dbname={$config['db_name']}", $config['db_user'], $config['db_pass'] );
        self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      }
      catch (PDOException $e) {
        echo "Database connection Error: " . $e->getMessage();
      }

    }

    public static function getConnection() {

      if (!self::$db) {
        new Dbconnect();
      }

      return self::$db;
    }

  }

?>
