# Audiences API Requests

### Create an Audience from an Audience File Automatically

##### If the isAutoProcess flag is set to yes, the platform will automatically break up
##### the audiences based on detected grouping columns

```php
use CommerceSignals\Exceptions\APIException;

try {
  $audienceFileId = '0a00017c-5b5b-148e-815b-5d8db2fe0009';
  $campaignId = '0a010284-576b-17d2-8157-6bff54c10000';

  $audience = new CommerceSignals\Audience([
    'usageTypes' => ['EXPOSED'],         // can be CONTROL or EXPOSED but must be an array
    'name' => 'demo_audience_file',      // the name of the audience we are creating
    'audienceFileId' => $audienceFileId, // the Audience File we are using to create the audiences
    'campaignId' => $campaignId,         // the Campaign associated with the Audience
    'isAutoProcess' => true              // auto break up the file
  ]);

  $newAudience = $api->audiences()
                  ->save($audience);

} catch (APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```
