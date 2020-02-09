AIML parser
---

## Run unit test (using docker)
Spin up php7.4 container with:
```
docker run --name aiml-parser -v ${PWD}:/var/www/html --rm -it php:7.4-fpm-alpine vendor/bin/phpunit
```