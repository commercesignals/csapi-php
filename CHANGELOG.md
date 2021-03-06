## 1.0.0 - Unreleased (Unagi)

### Todo
Finish writing tests

### Features
- (api) Add in estimated pricing for audiences
- (api) Added support for getting a list of and analyzing audience files
- (api) Added support for converting audience files to audiences
- (api) Added support for submitting signal requests
- (docs) Broke up code examples to their own pages

## 0.1.0 - 2017-01-04 (Capybara)

### Fixes
- (api) GET requests now use search params
- (api) GET requests now throw an APIException when non 200 response is returned
- (api) Better error message when using an invalid API base URL
- (api) Better error message when using an invalid API token

### Features
- (api) Support for getting a list of available merchants for a signal
- (api) Support for uploading audience files
- (api) Added logger to print out debug info
- (docs) Added example for pulling back summarized (calcuated) data for a signal request result

## 0.0.1 - 2017-03-17 (Foxtrot)

### Features
- (api) Automatic API authenication over OAuth with JWT
- (api) GET signals, signal requests, signal request resultsgit ch
- (api) GET, POST, PUT, PATCH campaigns
- (lib) Composer support
