<?php

namespace CommerceSignals\API;

class AudienceFiles extends Segment {

  /**
   * Helper for analyze urn segment
   */
  public function analyze($id = null) {
    return $this->api->addSegment(__FUNCTION__, $id);
  }
}
