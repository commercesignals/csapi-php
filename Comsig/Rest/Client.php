<?php

namespace Comsig\Rest;

require_once(__DIR__ . '/../autoload.php');

use Comsig\Auth\AuthToken;
use Comsig\Exceptions\AuthException;
use Comsig\API\API;

class Client {
  public function __construct($apiKey, $cert, $apiBase) {
    $authToken = new AuthToken($apiKey, $cert, $apiBase);

    try {
      $authToken->request();
      $this->api = new API($apiBase, $authToken->token);
    } catch (Exception $e) {
      print_r($e);
    }
  }

  public function getSignals() {
    print_r($this->api->get('signals'));
  }

  public function getSignalRequests($signalUUID) {
    return $this->api->get('signals/' . $signalUUID . '/requests');
  }
}
