AIML library for php
---
[![Build Status](https://travis-ci.org/ridesoft/AIML.svg?branch=master)](https://travis-ci.org/ridesoft/Aiml-parser)

Aiml Php library for php, compatible with Php 7.3>=.

AIML stands for Artificial Intelligence Modelling Language. AIML is an XML based markup language meant to create 
artificial intelligent applications.

[AIML Reference](https://www.pandorabots.com/docs/aiml-reference/)

## Supported language tags
* `<pattern>`
* `<template>`
* `<star>`
* `<srai>`

## How install it

`composer require ridesoft/aiml:~0.1.0`

## Base usage example

You can find this example in the [robot.php](tests/robot.php) file.
Run it with `docker run -v ${PWD}:/var/www/html --rm -it php:7.4-fpm-alpine sh -c "php tests/robot.php"`

```
<?php

require 'vendor/autoload.php';

$file = new \Ridesoft\AIML\File();

echo "Hello Aiml\n";
echo $file->setAimlFile(__DIR__ . '/files/simple.aiml')
        ->getCategory('Hello Aiml')
        ->getTemplate() . "\n";

$file2 = new \Ridesoft\AIML\File();
$category = $file2->setAimlFile(__DIR__ . '/files/srai.aiml')
    ->getCategory('Who Mauri is?');

echo "Who Mauri is? \n";
if ($category->isTemplateSrai()) {
    echo $file2->getCategory($category->getTemplate($category->getStars()))
        ->getTemplate(). "\n";
}
```

## Contributing
I develop this library in my free time: any help is really welcome: i would like in any case to follow the best practise
using a TDD approach or at least write unit tests for the code.

The code follow PSR2 standards.

### Check coding standards

```
docker run -v ${PWD}:/var/www/html --rm -it php:7.4-fpm-alpine vendor/bin/phpcs --standard=PSR2 /var/www/html/src
```

### Run unit test (using docker)

Spin up php7.4 container with:
```
docker run -v ${PWD}:/var/www/html --rm -it php:7.4-fpm-alpine vendor/bin/phpunit
```

