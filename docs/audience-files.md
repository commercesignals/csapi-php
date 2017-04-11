# Audience Files API Requests

### Get a list of available Audience Files

```php
try {
  $audienceFiles = $api->audienceFiles()
                    ->get();

} catch (CommerceSignals\Exceptions\APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```

### Upload a new Audience File

```php
try {
  $audienceFile = new CommerceSignals\AudienceFile([
    'file' => __DIR__ . '/example_exposed_file.psv.gz', // the actual file we are uploading
    'delimiter' => '|',  // the field delimter used in the file, most likely a ',' or '|'
  ]);

  $newAudienceFile = $api->audienceFiles()
                      ->save($audienceFile);

} catch (CommerceSignals\Exceptions\APIException $e) {
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
try {
  $audienceFileId = '0a10017c-5b5b-148e-815b-5d8e34e8400b';

  $api->audienceFiles($audienceFileId)
    ->analyze()
    ->post();

} catch (CommerceSignals\Exceptions\APIException $e) {
  printf('HTTP Error: %s - %s - %s',
    $e->getStatusCode(),
    $e->getMessage(),
    implode(', ', $e->getErrors())
  );
}
```
