# Signals API Requests

### Request available Signals

```php
$signals = $api->signals()
              ->get();
```

### View Merchants known to a Signal's Data Source

```php
$signalId = '0a000337-574f-223e-8156-4f3a98e707a1';

// view all merchants
$merchants = $api->signals($signalId)
               ->merchants()
               ->get();

// view only authorized merchants
$merchants = $api->signals($signalId)
               ->merchants()
               ->get(['authorized' => true]);
```
##### Note: the returned merchant array will include an `authorized` flag.  If it is set to 1, that merchant has been approved by the Data Source for you to use.  These are the only merchants you are able to use to submit Signal Requests from.

### View all Signal Requests for a specific Signal

```php
$signalId = '0a000337-574f-223e-8156-4f3a98e707a1';

$requests = $api->signals($signalId)
               ->requests()
               ->get();
```

### Estimate the cost of a signal request

```php
$signalId = '0a000337-574f-223e-8156-4f3a98e707a1';

$exposedAudienceId = '0a0001dc-5b10-1f13-815b-10a625660026';
$controlAudienceId = '0a0001dc-5b10-1f13-815b-10a624c30024';

$audienceIdList = [$exposedAudienceId, $controlAudienceId];

$cost = $api->signals($signalId)
          ->cost()
          ->get(['audienceId' => $audienceIdList]);
```


### View Results from a delivered Signal Request

```php
$signalId = '0a000337-574f-223e-8156-4f3a98e707a1';
$requestId = '0a00017c-5aac-1195-82ba-ae6ea3fa000a';

$results = $api->signals($signalId)
              ->requests($requestId)
              ->results()
              ->get();
```

#### Include Summarized Data (info dipslayed in Dashboard Results)

```php
$results = $api->signals($signalId)
              ->requests($requestId)
              ->results()
              ->get(['summarize' => true]);
```
