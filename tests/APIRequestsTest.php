<?php

use CommerceSignals\API;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Basic test on the API class to make sure we have
 *  all known methods and they are responding as needed
 *
 *  @author Corey Wilson
 */
class ApiTest extends PHPUnit_Framework_TestCase {

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

  public function tearDown() {
    $this->tearDownHttpMock();
  }

  public function testAuthToken() {
    $this->http->setUp();

    $api = new API('http://localhost:8082', [
      'apiKey' => '123456',
      'cert' => file_get_contents(__DIR__ . '/fake-cert.pem'),
    ]);

    $this->assertSame($api->getToken()->access_token, $this->authToken['access_token']);
  }
}
