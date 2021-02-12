[![Latest Stable Version](https://poser.pugx.org/pouler/apple-music-api/v/stable)](https://packagist.org/packages/pouler/apple-music-api)
[![Latest Unstable Version](https://poser.pugx.org/pouler/apple-music-api/v/unstable)](https://packagist.org/packages/pouler/apple-music-api)

# Apple Music API PHP

This is a PHP wrapper for the [Apple Music API](https://developer.apple.com/documentation/applemusicapi).

## Requirements
* PHP 7.2/8.0 or later.
* Symfony HTTP Client

## Installation
Install it using [Composer](https://getcomposer.org/):

```sh
composer require pouler/apple-music-api
```
## Usage
Before using the Apple Music API, you need to sign up for the Apple Developer Program. Read more about this [here](https://developer.apple.com/documentation/applemusicapi/getting_keys_and_creating_tokens).

```php
<?php

require 'vendor/autoload.php';

$tokenGenerator = new PouleR\AppleMusicAPI\AppleMusicAPITokenGenerator();
$jwtToken = $tokenGenerator->generateDeveloperToken(
    'team.id',
    'key.id',
    '/path/to/authkey.p8'
);

$curl = new \Symfony\Component\HttpClient\CurlHttpClient();
$client = new PouleR\AppleMusicAPI\APIClient($curl);
$client->setDeveloperToken($jwtToken);

$api = new PouleR\AppleMusicAPI\AppleMusicAPI($client);

$result = $api->getCatalogPlaylist('nl', 'pl.a56541661a7a4cca95ddeca24e5e5316');

print_r($result);
```
