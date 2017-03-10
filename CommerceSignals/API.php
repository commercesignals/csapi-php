<?php

namespace CommerceSignals;

require_once(__DIR__ . '/autoload.php');

use CommerceSignals\RestClient\RestClient;
use CommerceSignals\Auth\AuthToken;
use CommerceSignals\Exceptions\AuthException;
use CommerceSignals\Signal;

class API {
  private $token;
  private $client;

  public function __construct($apiKey, $cert, $apiBase) {
    $authToken = new AuthToken($apiKey, $cert, $apiBase);

    try {
      $authToken->request();

      $this->token = $authToken->token;
      $this->client = new RestClient([
        'base_url' => $apiBase . 'rest/v1/',
        'headers' => [ 'Authorization' => 'Bearer ' . $this->token->access_token],
      ]);

    } catch (Exception $e) {
      throw new AuthException($e);
    }
  }

  /**
   * Get a list of all Signals that are available to you
   */
  public function getSignals() {
    $createSignal = function($signal) {
      return new Signal($signal);
    };

    return array_map($createSignal, $this->getList('signals'));
  }

  /**
   * Get a specific Signal
   */
  public function getSignal($id) {
    return new Signal($this->get("signals/$id"));
  }

  /**
   * Get a list of objects
   */
  private function getList($url) {
    print 'getting list';
    $results = $this->client->get($url);
    return json_decode($results->response)->content;
  }

  /**
   * Get a single object
   */
  private function get($url) {
    $results = $this->client->get($url);
    return json_decode($results->response);
  }
}
