<?php

  class GeneralController {

    public $model;

    public function __construct($model) {
      $this->model = $model;
    }

    function getRequest() {

      if(isset($_GET['action'])) {
        switch($_GET['action']) {
          case "getall": 
            echo $this->model->getAll();
            break;
          case "getbyid": 
            echo $this->model->getById($_GET['id']);
            break;
          default: 
            echo "API route is not defined";
            break;
        }
      }

    }

    function postRequest() {

      $queryValues = "";

      foreach($this->model->fields as $field) {
        if(isset($_POST["{$field}"])) {
          $fieldValue = $_POST["{$field}"];
          $queryValues .= "'{$fieldValue}',";
        }
      }
      unset($field);

      $queryValues = substr($queryValues, 0, -1);
      
      echo $this->model->postItem($queryValues);

    }

    function putRequest() {

      parse_str(file_get_contents("php://input"), $post_vars);
      $queryValues = "";

      foreach($this->model->fields as $field) {
        if(isset($post_vars["{$field}"])) {
          $fieldValue = $post_vars["{$field}"];
          $queryValues .= "{$field}='{$fieldValue}',";
        }
      }
      unset($field);

      $queryValues = substr($queryValues, 0, -1);

      if(isset($post_vars['id'])) {
        echo $this->model->updateById($post_vars['id'], $queryValues);
      } else {
        echo "Item ID is not defined";
      }

    }

    function deleteRequest() {

      parse_str(file_get_contents("php://input"), $post_vars);

      if(isset($post_vars['id'])) {
        echo $this->model->deleteById($post_vars['id']);
      } else {
        echo "Item ID is not defined";
      }

    }

  }

?>
