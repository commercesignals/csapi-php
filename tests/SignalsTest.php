<?php

require_once __DIR__ . '/ApiRequests.php';

use CommerceSignals\Exceptions\APIException;

class SignalsTest extends ApiRequests {

  /**
   * GET /signals
   */
  public function testGetSignals() {
    $testSignalId = $this->genFakeId();
    $fakeSignals = [
      [ 'id' => 123 ],
      [ 'id' => 456 ],
      [ 'id' => $testSignalId ],
    ];

    parent::mockGet('signals', $fakeSignals);

    $signals = $this->getApi()
                ->signals()
                ->get();

    $this->assertSame(end($signals)->id, $testSignalId);
    $this->assertSame(count($signals), count($fakeSignals));
  }

  /**
   * GET /signals/$id
   */
  public function testGetSignal() {
    $testId = $this->genFakeId();
    parent::mockGet("signals/$testId", [
      'id' => $testId
    ]);

    $signal = $this->getApi()
                ->signals($testId)
                ->get();

    $this->assertSame($signal->id, $testId);
    $this->assertSame(count($signal), 1);
  }

  /**
   * GET /signals/$id/requests
   */
  public function testGetSignalRequests() {
    $testSignalId = $this->genFakeId();
    $testRequestId = $this->genFakeId();

    $fakeRequests = [
      [ 'id' => 123 ],
      [ 'id' => 456 ],
      [ 'id' => $testRequestId ],
    ];

    parent::mockGet("signals/$testSignalId/requests", $fakeRequests);

    $requests = $this->getApi()
                  ->signals($testSignalId)
                  ->requests()
                  ->get();

    $this->assertSame(end($requests)->id, $testRequestId);
    $this->assertSame(count($requests), count($fakeRequests));
  }

  /**
   * GET /signals/$id/requests/$id
   */
  public function testGetSignalRequest() {
    $testSignalId = $this->genFakeId();
    $testRequestId = $this->genFakeId();

    parent::mockGet("signals/$testSignalId/requests/$testRequestId", [
      'id' => $testRequestId
    ]);

    $request = $this->getApi()
                ->signals($testSignalId)
                ->requests($testRequestId)
                ->get();

    $this->assertSame($request->id, $testRequestId);
    $this->assertSame(count($request), 1);
  }

  /**
   * GET /signals/$id/requests/$id/results
   */
  public function testGetSignalRequestResults() {
    $testSignalId = $this->genFakeId();
    $testRequestId = $this->genFakeId();
    $testResultsId = $this->genFakeId();

    parent::mockGet("signals/$testSignalId/requests/$testRequestId/results", [
      'id' => $testResultsId
    ]);

    $results = $this->getApi()
                  ->signals($testSignalId)
                  ->requests($testRequestId)
                  ->results()
                  ->get();

    $this->assertSame($results->id, $testResultsId);
    $this->assertSame(count($results), 1);
  }

  /**
   * GET /signals/$id/requests/$id/results?summarize=true
   */
  public function testGetSignalRequestResultsSummarized() {
    $testSignalId = $this->genFakeId();
    $testRequestId = $this->genFakeId();
    $testResultsId = $this->genFakeId();
    $queryParams = ['summarize' => '1'];

    $url = "signals/$testSignalId/requests/$testRequestId/results?";
    $url .= http_build_query($queryParams);

    parent::mockGet($url, ['summarizedId' => $testResultsId], $queryParams);

    $results = $this->getApi()
                  ->signals($testSignalId)
                  ->requests($testRequestId)
                  ->results()
                  ->get($queryParams);

    $this->assertSame($results->summarizedId, $testResultsId);
    $this->assertSame(count($results), 1);
  }

  /**
   * GET /signals/$id/merchants
   */
  public function testGetSignalMerchants() {
    $testSignalId = $this->genFakeId();
    $testMerchantId = $this->genFakeId();

    $fakeMerchants = [
      [ 'id' => 123 ],
      [ 'id' => 456 ],
      [ 'id' => $testMerchantId ],
    ];

    parent::mockGet("signals/$testSignalId/merchants", $fakeMerchants);

    $merchants = $this->getApi()
                  ->signals($testSignalId)
                  ->merchants()
                  ->get();

    $this->assertSame(end($merchants)->id, $testMerchantId);
    $this->assertSame(count($merchants), count($fakeMerchants));
  }


  /**
   * GET /signals/$id/merchant/$id
   */
  public function testGetSignalMerchant() {
    $testSignalId = $this->genFakeId();
    $testMerchantId = $this->genFakeId();

    parent::mockGet("signals/$testSignalId/merchants/$testMerchantId", [
      'id' => $testMerchantId
    ]);

    $merchant = $this->getApi()
                  ->signals($testSignalId)
                  ->merchants($testMerchantId)
                  ->get();

    $this->assertSame($merchant->id, $testMerchantId);
    $this->assertSame(count($merchant), 1);
  }
}
