<?php

class Chat {

  // - -  Private Members

  private $name;


  // - -  Constructor
  public function __construct($name) {
    $this->name = $name;
  }


  // - - -  Public Functions
  public function getName() {
    return $this->name;
  }

  public function toJSON() {
    return json_encode(this);
  }
}