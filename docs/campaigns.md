# Campaigns API Requests

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
