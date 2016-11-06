<?php

  include_once '../models/animalmodel.php';
  include_once '/generalcontroller.php';

  $header = "Content-Type: application/json";
  header($header);

  $controller = new GeneralController(new AnimalModel());

  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {
    case 'GET':
      $controller->getRequest(); 
      break;
    case 'PUT':
      $controller->putRequest();
      break;
    case 'POST':
      $controller->postRequest(); 
      break;
    case 'DELETE':
      $controller->deleteRequest();
      break;
    default:
      echo "Wrong HTTP method";
      break;
  }

  /* EXAMPLE ROUTES:
  ACTION          REQUEST  URL
  Get All animal     GET     "/restapi/api/controllers/animalcontroller.php?action=getall"
  Get animal by ID   GET     "/restapi/api/controllers/animalcontroller.php?action=getbyid&id=1"
  Add animal         POST    "/restapi/api/controllers/animalcontroller.php"
  Update animal      PUT     "/restapi/api/controllers/animalcontroller.php"
  Delete animal      DELETE  "/restapi/api/controllers/animalcontroller.php"
  */

?>
