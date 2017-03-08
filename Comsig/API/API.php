<?php

namespace Comsig\API;

use Comsig\API\RestClient\RestClient;

class API {
  private $token;
  private $api;

  public function __construct($baseUrl, $token) {
    $this->token = $token;

    $this->api = new RestClient([
      'base_url' => $baseUrl . 'rest/v1/',
      'headers' => [ 'Authorization' => 'Bearer ' . $token->access_token ],
    ]);
  }

  public function get($url) {
    $results = $this->api->get($url);
    return json_decode($results->response)->content;
  }
}
