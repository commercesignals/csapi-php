# Audience Files API Requests

### Upload a new Audience File

```php
use CommerceSignals\Exceptions\APIException;

try {
  $audienceFile = new CommerceSignals\AudienceFile([
    'file' => __DIR__ . '/example_exposed_file.psv.gz', // the actual file we are uploading
    'delimiter' => '|',  // the field delimter used in the file, most likely a ',' or '|'
  ]);

  $newAudienceFile = $api->audienceFiles()
                      ->save($audienceFile);

} catch (APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```

### Analyze a newly uploaded Audience File

#### Note: files uploaded via S3 or SFTP are automatically analyzed so this call is only needed on audience files uploaded via the API

```php
use CommerceSignals\Exceptions\APIException;

try {
  $audienceFileId = '0a10017c-5b5b-148e-815b-5d8e34e8400b';

  $api->audienceFiles($audienceFileId)
    ->analyze()
    ->post();

} catch (APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```
