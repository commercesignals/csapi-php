# Signals API Requests

### Request available Signals

```php
$signals = $api->signals()
              ->get();
```

### View all Merchants known to a Signal's Data Source

```php
$signalId = '0a000337-574f-223e-8156-4f3a98e707a1';

$requests = $api->signals($signalId)
               ->merchants()
               ->get();
```
##### Note: the returned merchant array will include an `isAuthorized` flag.  If it is set to 1, that merchant has been approved by the Data Source for you to use.  These are the only merchants you are able to use to submit Signal Requests from.

### View all Signal Requests for a specific Signal

```php
$signalId = '0a000337-574f-223e-8156-4f3a98e707a1';

$requests = $api->signals($signalId)
               ->requests()
               ->get();
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
