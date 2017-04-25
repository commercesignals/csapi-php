<?php

namespace CommerceSignals;

class SignalRequest extends Resource {

  public function __construct($attributes = []) {
    if (is_string($attributes)) {
      $attributes = [ 'id' => $attributes ];
    }

    parent::__construct($attributes);

    if (isset($this->attributes['merchants']) === false) {
      $this->attributes['merchants'] = [];
    }

    if (isset($this->attributes['audiences']) === false) {
      $this->attributes['audiences'] = [];
    }
  }

  /**
   * Magic method for getting a generic set attribute
   */
  public function __get($name) {
    if ($name === 'id' && is_string($this->attributes)) {
      return $this->attributes;
    }

    return $this->attributes[$name];
  }

  /**
   * Set the signal request attributes based on the campaign attributes
   */
  public function setCampaign($campaign) {
    $this->attributes = array_merge($this->attributes, [
      'campaign' => $campaign->id,
      'startDate' => $campaign->startOn,
      'endDate' => $campaign->endOn,
      'postPeriodDays' => $campaign->postPeriodDays,
      'preCampaignStartDate' => $campaign->prePeriodStartOn,
      'preCampaignEndDate' => $campaign->prePeriodEndOn,
    ]);

    $merchants = array_map(function($merchant) {
      return [ 'merchant' => $merchant->id ];
    }, $campaign->merchants);

    $this->attributes['merchants'] = array_merge($this->attributes['merchants'], $merchants);
  }

  /**
   * Attach an audience pair to the signal request.  The $audiences param
   * must include both control and exposed audience ids
   *
   * $audiences Array [('control' => 'control-id'), ('exposed' => 'exposed-id')]
   *         e. g. [ 'control' => $controlId, 'exposed' => $exposedId ]
   */
  public function addAudiencePair(Array $audiences) {
    if (!isset($audiences['control']) || !isset($audiences['exposed'])) {
      throw new \Exception('Audience pair must include a control and exposed audience');
    }

    $exposed = [
      'audienceId' => $audiences['exposed'],
      'isExposed' => true,
      'controlAudienceId' => $audiences['control']
    ];

    $control = [
      'audienceId' => $audiences['control'],
      'isExposed' => false
    ];

    array_push($this->attributes['audiences'], $exposed, $control);
  }
}
