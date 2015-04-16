#!/bin/bash

set -eu

CURDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

docker build -t php:fpm-custom ${CURDIR}/php-fpm
docker build -t nginx:custom ${CURDIR}/nginx

docker run -d --name sc-php -v ${CURDIR}/src:/var/www/app php:fpm-custom
docker run -d -p 80:80 -p 443:443 --link sc-php:php -v ${CURDIR}/src:/var/www/app nginx:custom
