<?php

require __DIR__ . '/ApiRequests.php';

class AuthTest extends ApiRequests {

  public function testAuthToken() {
    $this->http->setUp();
    $api = $this->getApi();

    $this->assertSame($api->getToken()->access_token, $this->authToken['access_token']);
  }
}
