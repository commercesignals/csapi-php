<?php

use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CommerceSignals\API;

/**
 *  Basic test on the API class to make sure we have
 *  all known methods and they are responding as needed
 *
 *  @author Corey Wilson
 */
class ApiRequests extends PHPUnit_Framework_TestCase {

  use HttpMockTrait;

  public $authToken = [
    'access_token' => '1234567890',
    'token_type' => 'bearer',
    'refresh_token' => '0987654321',
    'expires_in' => 899,
    'scope' => 'read write',
    'jti' => '999888777',
  ];

  public static function setUpBeforeClass() {
    static::setUpHttpMockBeforeClass('8082', 'localhost');
  }

  public static function tearDownAfterClass() {
    static::tearDownHttpMockAfterClass();
  }

  /**
   * Handle the auth requests
   */
  public function setUp() {
    $this->setUpHttpMock();

    $this->http->mock
      ->when()
        ->callback(function (Request $request) {
          return
            $request->getMethod() === 'POST' &&
            $request->getPathInfo() === '/oauth/token' &&
            $request->headers->has('authorization') &&
            $request->request->has('grant_type') &&
            $request->request->has('assertion');
        })
      ->then()
        ->body(json_encode($this->authToken))
        ->end();
  }

  public function mockGet($url, $response, $queryParams = []) {
    $this->http->mock
        ->when()
            ->methodIs('GET')
            ->pathIs("/rest/v1/$url")
            ->queryParamsAre($queryParams)
        ->then()
            ->body(json_encode($response))
        ->end();

    $this->http->setUp();
  }

  public function genFakeId() {
    return mt_rand(1, 10000);
  }

  public function tearDown() {
    $this->tearDownHttpMock();
  }

  public function getApi() {
    return new API('http://localhost:8082', [
      'apiKey' => '123456',
      'cert' => file_get_contents(__DIR__ . '/fake-cert.pem'),
    ]);
  }
}
