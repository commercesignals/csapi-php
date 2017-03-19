<?php

use CommerceSignals\API;

/**
 *  Basic test on the API class to make sure we have
 *  all known methods and they are responding as needed
 *
 *  @author Corey Wilson
 */
class ApiTest extends PHPUnit_Framework_TestCase {

  /**
   * Just check to make sure the API class has no syntax error
   */
  public function testNoSyntaxErrors() {
    $api = new API('https://api.commercesignals.com');

    $this->assertTrue(is_object($api));
    unset($api);
  }

  /**
   * Make sure we have a signals method and it returns a new API object
   */
  public function testSignalsMethod() {
    $api = new API('https://api.commercesignals.com');
    $signalsApi = $api->signals();

    $this->assertTrue(is_object($signalsApi));
    unset($api);
  }

  /**
   * Make sure we have a signals method and it returns a new API object
   */
  public function testCampaignsMethod() {
    $api = new API('https://api.commercesignals.com');
    $campaignsApi = $api->campaigns();

    $this->assertTrue(is_object($campaignsApi));
    unset($api);
  }

  /**
   * Make sure we have get method (it should return NULL)
   */
  public function testGetMethod() {
    $api = new API('https://api.commercesignals.com');

    $this->assertTrue(is_null($api->get()));
    unset($api);
  }
}
