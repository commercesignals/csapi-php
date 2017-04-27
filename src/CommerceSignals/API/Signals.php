<?php

namespace CommerceSignals\API;

class Signals extends Segment {

  /**
   * Helper for requests urn segment
   */
  public function requests($id = null) {
    return $this->api->addSegment(__FUNCTION__, $id);
  }

  /**
   * Helper for results urn segment
   */
  public function results($id = null) {
    return $this->api->addSegment(__FUNCTION__, $id);
  }

  /**
   * Helper for merchants urn segment
   */
  public function merchants($id = null) {
    return $this->api->addSegment(__FUNCTION__, $id);
  }

  /**
   * Helper for estimating cost
   */
  public function cost($id = null) {
    return $this->api->addSegment(__FUNCTION__, $id);
  }
}
