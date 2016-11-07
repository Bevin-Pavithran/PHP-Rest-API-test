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
      $field = array();
      return $this->db_access->getData($query,$field);
    }

    function getById($id) {
      $query = "SELECT {$this->fields_str} FROM {$this->table_name} WHERE _id= :id";
      $field = array("id"=>$id);
      return $this->db_access->getData($query,$field);
    }

    function postItem($insert) {
      $query = "INSERT INTO {$this->table_name} ({$this->fields_str}) VALUES ({$this->parameterizeDataForInsert($insert)})";
      return $this->db_access->postData($query,$insert);
    }

    function updateById($id,$set) {
      $query = "UPDATE {$this->table_name} SET {$this->parameterizeData($set)} WHERE _id = :id";
      $set["id"] = $id;
      return $this->db_access->postData($query,$set);
    }

    function deleteById($id) {
      $query = "DELETE FROM {$this->table_name} WHERE _id = :id";
      $field = array("id"=>$id);
      return $this->db_access->postData($query,$field);
    }

    //Helpers
    function parameterizeData($data) {
      $str = "";
      foreach($data as $key => $value) {
        $str .= $key." = :".$key;
      }
      return $str;
    }

    function parameterizeDataForInsert($data) {
      $str = "";
      foreach($data as $key => $value) {
        $str .= ":".$key.",";
      }
      $str = substr($str, 0, -1);
      return $str;
    }

  }

?>
