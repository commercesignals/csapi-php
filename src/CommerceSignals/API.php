<?php

namespace CommerceSignals;

require_once(__DIR__ . '/autoload.php');

use CommerceSignals\API\Signals;
use CommerceSignals\RestClient\RestClient;
use CommerceSignals\Auth\AuthToken;
use CommerceSignals\Exceptions\URLException;
use CommerceSignals\Exceptions\AuthException;
use CommerceSignals\Exceptions\APIException;

class API {
  const API_PREFIX = 'rest/v1/';
  private $token = '';
  private $client = '';

  private $urlSegments = [];

  public function __construct($apiBase, $auth = null) {
    if (is_array($auth)) {
      $this->token = $this->authorize($auth['apiKey'], $auth['cert'], $apiBase);
    }

    $this->client = $this->createClient($apiBase);
    $this->signals = new Signals($this);
  }

  /**
   * If there's an attempt to call a method not on the root
   * level see if there if the first segment called can
   * respond to it
   */
  public function __call($name, $arguments) {
    if (count($this->urlSegments) !== 0) {
      $segmentRoot = $this->urlSegments[0];

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
   * Helper for audience-files urn segment
   */
  public function audienceFiles($id = null) {
    $this->urlSegments = [];
    return $this->addSegment('audience-files', $id);
  }

  /**
   * Helper for signals urn segment
   */
  public function signals($id = null) {
    $this->urlSegments = [];
    return $this->addSegment(__FUNCTION__, $id);
  }

  /**
   * Helper for results urn segment
   */
  public function campaigns($id = null) {
    $this->urlSegments = [];
    return $this->addSegment(__FUNCTION__, $id);
  }

  /**
   * Make a get request with the urlSegment stack
   */
  public function get($params = []) {
    $urn = $this->buildUrn();
    $results = $this->client->get($urn, $params);

    // if the results are paginated, return the content
    // rather than the pagination information
    $response = $this->validateResponse($results);

    if (isset($response->numberOfElements)) {
      return $response->content;
    }

    return $response;
  }

  /**
   * Do a create or update on the DB based
   * if we have an id or not
   */
  public function save($object) {
    $payload = method_exists($object, 'getAttributes') ?
      $object->getAttributes() :
      get_object_vars($object);

    if (isset($object->id)) {
      return $this->put($payload);
    }

    $response = $this->create($payload);
    $class = get_class($object);

    return new $class($response);
  }

  /**
   * Update specific properties of the resource
   * with a PATCH request
   */
  public function update($payload = []) {
    $urn = $this->buildUrn();
    $results = $this->client->patch($urn, $payload);

    return $this->validateResponse($results);
  }

  /**
   * POST the resource to the API to create an object
   */
  public function create($payload) {
    $urn = $this->buildUrn();
    $results = $this->client->post($urn, $payload);

    return $this->validateResponse($results);
  }

  /**
   * PUT the resource to the API to update an object
   */
  private function put($payload) {
    $urn = $this->buildUrn();
    $results = $this->client->put($urn, $payload);

    return $this->validateResponse($results);
  }

  /**
   * Check the response code from the REST request
   * to make sure we have a 2**, otherwise, throw
   * an APIException
   */
  private function validateResponse($results) {
    Logger::out(3, "Resonse: " . print_r($results, true));

    $response = json_decode($results->response);
    $responseCode = $results->info->http_code;

    if ($responseCode < 200 || $responseCode >= 300) {
      $errorType = isset($response->errorType) ? $response->errorType : 'Unknown';

      $errors = [];

      if (isset($response->errors)) {
        $errors = $response->errors;
      }

      if (isset($results->error)) {
        $errors[] = $results->error;
      }

      Logger::out(3, "Resonse body: {$results->response}");

      throw new APIException(
        $errorType,
        $errors,
        $responseCode
      );
    }

    return $response;
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
   * Get the access token
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * Create the RestClient object
   */
  private function createClient($apiBase) {
    $apiBase = rtrim($apiBase, '/') . '/';
    $clientParams = ['base_url' => $apiBase . self::API_PREFIX];

    if ($this->token !== '') {
      $clientParams['headers'] = [
        'Authorization' => 'Bearer ' . $this->token->access_token,
        'Content-Type' => 'application/json',
      ];
    }

    return new RestClient($clientParams);
  }

  /**
   * Request an auth token using provided api key and cert
   */
  private function authorize($apiKey, $cert, $apiBase) {
    $authToken = new AuthToken($apiKey, $cert, $apiBase);

    try {
      $authToken->request();
      return $authToken->token;

    } catch (Exception $e) {
      throw new AuthException($e);
    }
  }
}
