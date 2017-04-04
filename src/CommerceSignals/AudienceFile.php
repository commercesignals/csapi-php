<?php

namespace CommerceSignals;

use CURLFile;

class AudienceFile {
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

    foreach($attributes as $name => $value) {
      $this->__set($name, $value);
    }
  }

  /**
   * Magic method for setting generic attributes
   */
  public function __set($name, $value) {
    if ($name === 'file') {
      $value = new CURLFile($value, 'image/jpeg');
    }

    $this->attributes[$name] = $value;
  }

  /**
   * Return all this objects attributes
   */
  public function getAttributes() {
    return $this->attributes;
  }
}
