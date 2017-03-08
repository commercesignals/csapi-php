<?php

namespace Comsig\Auth;

use Comsig\Auth\JWT;
use Comsig\Exceptions\AuthException;

use \DateTime;
use \DateTimeZone;
use \DateInterval;

class AuthToken {
  const API_SEGMENT = '/oauth/token';
  const ACCESS_TOKEN_MINUTES = 10;

  public $token;
  private $endpoint;
  private $apiKey;
  private $cert;

  public function __construct($apiKey, $cert, $apiBase) {
    $this->endpoint = $apiBase . SELF::API_SEGMENT;
    $this->cert = $cert;
    $this->apiKey = $apiKey;
  }

  /**
   * Make a request to get an access token using a signed JWT
   */
  public function request() {
    $signedJWT = $this->signJWT();

    $postParams = [
      'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
      'assertion' => $signedJWT
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => $this->endpoint,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => http_build_query($postParams),
      CURLOPT_USERPWD => 'signals-api:',
      CURLOPT_RETURNTRANSFER => true
    ]);

    $result = curl_exec($curl);
    curl_close($curl);

    $this->token = json_decode($result);

    if (property_exists($this->token, 'error')) {
      $error = $this->accessToken->error . ': ' . $this->accessToken->error_description;
      throw new AuthException($error);
    }
  }

  /**
   * Create a signed JWT token
   */
  private function signJWT() {
    $now = new DateTime('now', new DateTimeZone('UTC'));

    $expireOn = new DateTime('now', new DateTimeZone('UTC'));
    $expireOn->add(new DateInterval('PT' . self::ACCESS_TOKEN_MINUTES . 'M'));

    $claims = [
      'iss' => $this->apiKey,
      'aud' => $this->endpoint,
      'exp' => $expireOn->getTimestamp(),
      'iat' => $now->getTimestamp()
    ];

    return JWT::encode($claims, $this->cert);
  }

}
