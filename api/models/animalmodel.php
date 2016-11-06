<?php

  include_once '/generalmodel.php';

  class AnimalModel extends GeneralModel {

    private $table_name = "animals";
    public $fields = array("type","name");

    public function __construct() {
      parent::__construct($this->table_name, $this->fields);
    }

    //ide johetnek meg egyedi lekerdezesek.

  }

?>
