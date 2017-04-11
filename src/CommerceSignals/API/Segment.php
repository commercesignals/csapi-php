<?php

namespace CommerceSignals\API;

class Segment {
  protected $api;

  public function __construct($api) {
    $this->api = $api;
  }
}
