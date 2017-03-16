# Commerce Signals API Library

Library to interface with the Commerce Signals platform.

## Installing with Composer

`composer install commercesignals/csapi-php`

## Usage

### Authorize your client

```php
const CERT_FILE_NAME = 'my-secret-api-key-cert.pem';
const API_KEY = 'my-secret-api-key';
const API_BASE = 'https://api.commercesignals.com/';

$api = new CommerceSignals\API(API_BASE, [
  'apiKey' => API_KEY,
  'cert' => file_get_contents(__DIR__ . '/' . CERT_FILE_NAME)
]);
```

### Request available Signals

```php
$signals = $api->signals()
              ->get();
```

### View all Signal Requests for a specific Signal

```php
$signalId = 'signal-id-to-view-requests-for';

$requests = $api->signals($signalId)
               ->requests()
               ->get();
```

### View Results from a delivered Signal Request

```php
$signalId = 'signal-id-to-view-requests-for';
$requestId = 'request-id-to-view-results-for';

$results = $api->signals($signalId)
              ->requests($requestId)
              ->results()
              ->get();
```

### View all my campaigns

```php
$campaigns = $api->campaigns()
              ->get();
```

### Create a new Campaign

```php
use CommerceSignals\Exceptions\APIException;

try {
  $campaign = new CommerceSignals\Campaign([
    'name' => 'My New Campaign',
    'description' => 'My New Demo Campaign',
  ]);

  $newCampaign = $api->campaigns()
                  ->save($campaign);

} catch (APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```

### Update an existing Campaign

```php
use CommerceSignals\Exceptions\APIException;

try {
  $api->campaigns('0a00017c-5aac-1195-815a-ae8ea3fa000a')
    ->update([
      'name' => 'Updated Campaign Name',
      'description' => 'Updated Campaign Description',
    ]);

} catch (APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```

Demo
---------
A demo project using this library is available on another github repo.
