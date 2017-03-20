<?php

namespace CommerceSignals\Exceptions;

class APIException extends \Exception {
  protected $statusCode;
  protected $errors = [];

  /**
   * Store the HTTP status code in a protected attribute
   */
  public function __construct($errorType, $errors, $statusCode) {
    $this->statusCode = $statusCode;
    $this->errors = $errors;

    parent::__construct($errorType, $statusCode);
  }

  /**
   * Helper method for getting the HTTP status code
   */
  public function getStatusCode() {
    return $this->statusCode;
  }

  /**
   * Helper method for getting the errors array
   */
  public function getErrors() {
    return $this->errors;
  }
}
