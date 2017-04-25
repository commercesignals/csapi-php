# Submitting Signal Requests

The SignalRequest object has a few helpers methods that can make building the Signal Request
object a litte easier.  When creating a signal request, you can either use the helper methods
available or construct the SignalRequest object by hand.

### Using Helper Methods

```php
  $exposedAudienceId = '0a0001dc-5b10-1f13-815b-10a625660026'; // sample exposed Audience id
  $controlAudienceId = '0a0001dc-5b10-1f13-815b-10a624c30024'; // sample control Audience id
  $signalId = '7f000101-5b10-10f1-815b-109d72bd1192';          // sample measurement Signal id

  // get the Campaign from that database that includes the dates of the
  // campaign and the merchants associated with the campaign (as long as
  // this meta info was provided when creating the campaign)
  $campaign = $api->campaigns('0a0001dc-5b10-1f13-815b-10a5effa001e')->get();

  $signalRequest = new CommerceSignals\SignalRequest();

  // the setCampaign method will set all the signal request
  // details to match the details of the associated Campaign
  $signalRequest->setCampaign($campaign);

  // The addAudiencePair method will create the audience structure
  // for the given audiences for the Signal Request
  $signalRequest->addAudiencePair([
    'exposed' => $exposedAudienceId,
    'control' => $controlAudienceId,
  ]);

  // Submit the signal
  $signalRequest = $api->signals($signalId)
                    ->requests()
                    ->save($signalRequest);

  // print the request ID that can be used to check the status
  // of the request and view the results when they are ready
  print $signalRequest->id;
```

### Building the Signal Request object by hand

```php
  $exposedAudienceId = '0a0001dc-5b10-1f13-815b-10a625660026'; // sample exposed Audience id
  $controlAudienceId = '0a0001dc-5b10-1f13-815b-10a624c30024'; // sample control Audience id
  $signalId = '7f000101-5b10-10f1-815b-109d72bd1192';          // sample measurement Signal id
  $campaignId = '0a0001dc-5b10-1f13-815b-10a5effa001e';        // sample Campaign id
  $merchantId = '0a010233-56b3-1f32-8156-b33f6cdf0110';        // sample Merchant id

  // get the Campaign from that database that includes the dates of the
  // campaign and the merchants associated with the campaign (as long as
  // this meta info was provided when creating the campaign)
  $campaign = $api->campaigns('0a0001dc-5b10-1f13-815b-10a5effa001e')->get();

  $signalRequest = new CommerceSignals\SignalRequest([
    'campaign' => $campaignId,
    'startDate' => '2017-01-04',
    'endDate' => '2017-04-04',,
    'postPeriodDays' => 30,
    'preCampaignStartDate' => '2016-12-01',
    'preCampaignEndDate' => '2017-01-03',
    'merchants' => [
      [ 'merchant' => $merchantId ]
    ],
    'audiences' => [
      [
        'audienceId' => $controlAudienceId,
        'isExposed' => false,
      ],
      [
        'audienceId' => $exposedAudienceId,
        'isExposed' => true,
        'controlAudienceId' => $controlAudienceId
      ]
    ]
  ]);

  // Submit the signal
  $signalRequest = $api->signals($signalId)
                    ->requests()
                    ->save($signalRequest);

  // print the request ID that can be used to check the status
  // of the request and view the results when they are ready
  print $signalRequest->id;
```
