<?php
  $header = "Content-Type: application/json";
  header($header);

  class GeneralController {

    public $model;

    public function __construct($model) {
      $this->model = $model;
    }

    function parseJson($data) {
      return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function getRequest() {

      if(isset($_GET['action'])) {
        switch($_GET['action']) {
          case "getall":
            try {
              echo $this->parseJson($this->model->getAll());
            } catch(Exception $e) {
              echo $this->parseJson(array("error" => true, "message" => $e->getMessage()));
            }
            break;
          case "getbyid":
            try {
              echo $this->parseJson($this->model->getById($_GET['id']));
            } catch(Exception $e) {
              echo $this->parseJson(array("error" => true, "message" => $e->getMessage()));
            }
            break;
          default:
            echo $this->parseJson(array("error" => true, "message" => "API route is not defined"));
            break;
        }
      }

    }

    function postRequest() {

      $queryValues = array();

      foreach($this->model->fields as $field) {
        if(isset($_POST["{$field}"])) {
          $fieldValue = $_POST["{$field}"];
          $queryValues[$field] = $fieldValue;
        }
      }
      unset($field);
      
      try {
        echo $this->parseJson($this->model->postItem($queryValues));
      } catch(Exception $e) {
        echo $this->parseJson(array("error" => true, "message" => $e->getMessage()));
      }

    }

    function putRequest() {

      parse_str(file_get_contents("php://input"), $post_vars);

      $queryValues = array();

      foreach($this->model->fields as $field) {
        if(isset($post_vars["{$field}"])) {
          $fieldValue = $post_vars["{$field}"];
          $queryValues[$field] = $fieldValue;
        }
      }
      unset($field);

      if(isset($post_vars['id'])) {
        try {
          echo $this->parseJson($this->model->updateById($post_vars['id'], $queryValues));
        } catch(Exception $e) {
          echo $this->parseJson(array("error" => true, "message" => $e->getMessage()));
        }
      } else {
        echo $this->parseJson(array("error" => true, "message" => "Item ID is not defined"));
      }

    }

    function deleteRequest() {

      parse_str(file_get_contents("php://input"), $post_vars);

      if(isset($post_vars['id'])) {
        try {
          echo $this->parseJson($this->model->deleteById($post_vars['id']));
        } catch(Exception $e) {
          echo $this->parseJson(array("error" => true, "message" => $e->getMessage()));
        }
      } else {
        echo $this->parseJson(array("error" => true, "message" => "Item ID is not defined"));
      }

    }

  }

?>
