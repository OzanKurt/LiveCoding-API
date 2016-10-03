# LiveCoding-API

[![Latest Stable Version](https://poser.pugx.org/ozankurt/livecoding-api/v/stable)](https://packagist.org/packages/ozankurt/livecoding-api) 
[![Latest Unstable Version](https://poser.pugx.org/ozankurt/livecoding-api/v/unstable)](https://packagist.org/packages/ozankurt/livecoding-api) 
[![License](https://poser.pugx.org/ozankurt/livecoding-api/license)](https://packagist.org/packages/ozankurt/livecoding-api)
[![Total Downloads](https://poser.pugx.org/ozankurt/livecoding-api/downloads)](https://packagist.org/packages/ozankurt/livecoding-api) 
[![Travis-CI](https://api.travis-ci.org/OzanKurt/LiveCoding-API.svg)](https://travis-ci.org/OzanKurt/LiveCoding-API)
[![Code Climate](https://codeclimate.com/github/OzanKurt/LiveCoding-API/badges/gpa.svg)](https://codeclimate.com/github/OzanKurt/LiveCoding-API)

This package is a wrapper of LiveCodingTV API for PHP.

## Usage

##### Pure PHP

```php
use Kurt\LiveCoding\Client;
use Kurt\LiveCoding\LiveCoding;

$storagePath = __DIR__.'/storage/livecoding';

$liveCodingClient = new Client([
    'id' => 'CLIENT_ID', // required
    'secret' => 'CLIENT_SECRET', // required
    'redirectUrl' => 'http://localhost:8000/', // required

    /** 
     * All classes under Kurt\LiveCoding\Scopes namespace are accepted as a valid scope.
     * By default ReadScope will be instantiated.
     */
    'scope' => new Kurt\LiveCoding\Scopes\ReadScope, // optional

    /** 
     * All classes under Kurt\LiveCoding\Storages namespace are accepted as a valid scope.
     * In order to use FileStorage you have to specify a storage path.
     * By default SessionStorage will be instantiated.
     */
    'storage' => new Kurt\LiveCoding\Storages\FileStorage($storagePath), // optional
]);

$liveCoding = new LiveCoding($liveCodingClient);

if (!$liveCoding->isAuthorized()) {
    echo '<a href='.$liveCoding->getAuthLink().'>Connect My LiveCodingTV Account</a>';
} else {
    $results = $liveCoding->users('ozankurt');
}
```

## Contribution Guidelines

Any kind of code improvement or additions are appreciated.

## License

The LiveCoding-API is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
