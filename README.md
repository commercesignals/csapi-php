<p align="center"><img src="https://s3.amazonaws.com/comsig-marketing/databridge-black-400.png" alt="Databridge by Commerce Signals"></p>


[![Build Status](https://travis-ci.org/commercesignals/csapi-php.svg?branch=master)](https://travis-ci.org/commercesignals/csapi-php) [![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](https://opensource.org/licenses/BSD-3-Clause)

Library to interface with the Commerce Signals platform.

## Installing with Composer

`composer install commercesignals/csapi-php`

## Usage

### Authorize your client

```php
const CERT_FILE_NAME = 'my-api-key-private-cert.pem';
const API_KEY = '0b70012a-5a7a-2b90-815a-aa73a7f8001a'; // My API Key
const API_BASE = 'https://api.commercesignals.com/';

$api = new CommerceSignals\API(API_BASE, [
  'apiKey' => API_KEY,
  'cert' => file_get_contents(__DIR__ . '/' . CERT_FILE_NAME)
]);
```

### The API class
The main API class is used to build the API request to issue.

The methods of the API call can be chained to create the segments of the request you are making.
Each chained method has an optional `$id` paramater that can be passed to request a specific resource from the segment part.
The final method in the call determins the type of HTTP request being made and has an optional `$payload` paramater that will be used as the request BODY.

```
get() => GET request
update() => PATCH request
save() => POST or PUT (depending on if the payload BODY has an id set or not)
```

##### Example
```php
  $api->signals('0a000337-574f-223e-8156-4f3a98e707a1')
    ->requests('0a00017c-5aac-1195-82ba-ae6ea3fa000a')
    ->results()
    ->get();
```
##### HTTP Request

`GET https://api.commercesignals.com/rest/v1/signals/0a00...07a1/requests/0a00...a000a/results`


### Request available Signals

```php
$signals = $api->signals()
              ->get();
```

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
  $api->campaigns('0a00017c-5aac-1195-82ba-ae6ea3fa000a')
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

