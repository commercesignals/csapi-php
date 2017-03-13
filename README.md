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

$auth = [
  'apiKey' => API_KEY,
  'cert' => file_get_contents(__DIR__ . '/' . CERT_FILE_NAME)
];

$api = new CommerceSignals\API(API_BASE, $auth);
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

Demo
---------
A demo project using this library is available on another github repo.
