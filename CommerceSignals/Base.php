<?php

namespace CommerceSignals;

class Base {
  public function __construct($properties) {
    foreach (get_object_vars($properties) as $property => $value) {
      $this->$property = $value;
    }
  }
}
