AIML library for php
---
[![Build Status](https://travis-ci.org/ridesoft/Aiml-parser.svg?branch=master)](https://travis-ci.org/ridesoft/Aiml-parser)

Aiml Php library for php compatible with Php 7.3>=.

## How use it
```
$file = new Ridesoft\AIML\File();
$categories = $file->setAimlFile('path/to/myAimlValidFile')
    ->getCategories();
```
## How install it

Clone this repositories

## Run unit test (using docker)
Spin up php7.4 container with:
```
docker run --name aiml-parser -v ${PWD}:/var/www/html --rm -it php:7.4-fpm-alpine vendor/bin/phpunit
```