<?php

  require_once('../dbaccess.php');

  class GeneralModel {

    private $table_name;
    public $fields = array();
    private $fields_str;
    protected $db_access;

    public function __construct($table, $fields) {
      $this->table_name = $table;
      $this->fields = $fields;
      $this->fields_str = implode(",", $fields);
      $this->db_access = Dbaccess::getDbAccess();
    }
    
    function getAll() {
      $query = "SELECT {$this->fields_str} FROM {$this->table_name}";
      return $this->db_access->getData($query);
    }

    function getById($id) {
      $query = "SELECT {$this->fields_str} FROM {$this->table_name} WHERE _id={$id}";
      return $this->db_access->getData($query);
    }

    function postItem($insert) {
      $query = "INSERT INTO {$this->table_name} ({$this->fields_str}) VALUES ({$insert})";
      return $this->db_access->postData($query);
    }

    function updateById($id,$set) {
      $query = "UPDATE {$this->table_name} SET {$set} WHERE _id={$id}";
      return $this->db_access->postData($query);
    }

    function deleteById($id) {
      $query = "DELETE FROM {$this->table_name} WHERE _id={$id}";
      return $this->db_access->postData($query);
    }

  }

?>
