<?php

namespace CommerceSignals;

class Campaign {
  private $attributes = [];

  /**
   * Attributes can be an assoc array or
   * an object, if it's an object we pull
   * out the properties in to an array
   */
  public function __construct($attributes) {
    if (is_object($attributes)) {
      $attributes = get_object_vars($attributes);
    }

    $this->attributes = $attributes;
  }

  /**
   * Magic method for setting generic attributes
   */
  public function __set($name, $value) {
    $this->attributes[$name] = $value;
  }

  /**
   * Return all this objects attributes
   */
  public function getAttributes() {
    return $this->attributes;
  }
}
