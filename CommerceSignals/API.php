<?php

namespace CommerceSignals;

require_once(__DIR__ . '/autoload.php');

use CommerceSignals\RestClient\RestClient;
use CommerceSignals\Auth\AuthToken;
use CommerceSignals\Exceptions\URLException;
use CommerceSignals\Exceptions\AuthException;

class API {
  private $token;
  private $client;

  private $urlSegments = [];

  public function __construct($apiKey, $cert, $apiBase) {
    $this->authorize($apiKey, $cert, $apiBase);
    $this->_signals = new Signal($this);
  }

  /**
   * If there's an attempt to call a method not on the root
   * level see if there if the first segment called can
   * respond to it
   */
  public function __call($name, $arguments) {
    if (count($this->urlSegments) !== 0) {
      $segmentRoot = '_' . $this->urlSegments[0];

      if (property_exists($this, $segmentRoot) === false ||
          method_exists($this->$segmentRoot, $name) === false) {

        $message = 'Invalid URL construction. ';
        $message .= 'URL: ' . $this->buildUrn() . "/$name is invalid.";
        throw new URLException($message);
      }

      return $this->$segmentRoot->$name(implode(',', $arguments));
    }
  }

  /**
   * Helper for signals urn segment
   */
  public function signals($id = null) {
    return $this->addSegment(__FUNCTION__, $id);
  }

  /**
   * Helper for results urn segment
   */
  public function campaigns($id = null) {
    return $this->addSegment(__FUNCTION__, $id);
  }

  /**
   * Make a get request with the urlSegment stack
   */
  public function get() {
    $urn = $this->buildUrn();
    $results = $this->client->get($urn);

    return json_decode($results->response);
  }

  /**
   * Build the URN based on what's on the urlSegment stack
   */
  private function buildUrn() {
    $urn = implode('/', $this->urlSegments);
    return rtrim($urn, '/');
  }

  /**
   * Keep a stack of segments from all request parts
   * that have been made
   */
  public function addSegment($name, $id = null) {
    array_push($this->urlSegments, $name);

    if ($id !== null) {
      array_push($this->urlSegments, $id);
    }

    return $this;
  }

  /**
   * Request an auth token using provided api key and cert
   */
  private function authorize($apiKey, $cert, $apiBase) {
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
}
