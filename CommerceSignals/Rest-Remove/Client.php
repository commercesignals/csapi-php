<?php

namespace CommerceSignals\Rest;

require_once(__DIR__ . '/../autoload.php');

use CommerceSignals\Auth\AuthToken;
use CommerceSignals\Exceptions\AuthException;
use CommerceSignals\API\API;

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
    return $this->api->getList('signals');
  }

  public function getSignalRequests($signalId) {
    $url = implode('/', ['signals', $signalId, 'requests']);
    return $this->api->getList($url);
  }

  public function getSignalRequest($signalId, $requestId) {
    $url = implode('/', ['signals', $signalId, 'requests', $requestId]);
    return $this->api->get($url);
  }

  public function getSignalResults($signalId, $resultsId) {
    $url = implode('/', ['signals', $signalId, 'requests', $resultsId, 'results']);
    return $this->api->get($url);
  }
}
