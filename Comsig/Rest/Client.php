<?php

namespace Comsig\Rest;

require_once(dirname(__FILE__) . '/../Auth/AuthToken.php');
require_once(dirname(__FILE__) . '/../Exceptions/AuthException.php');

use Comsig\Auth\AuthToken;
use Comsig\Exceptions\AuthException;

class Client {
  public function __construct($apiKey, $cert, $apiBase) {
    $authToken = new AuthToken($apiKey, $cert, $apiBase);

    try {
      $authToken->request();
      print_r($authToken->token);

    } catch (AuthException $e) {
      print $e->getMessage() . "\n";
    }
  }
}
