#!/bin/bash

set -eu

CURDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

# 起動中のdockerコンテナを停止&削除
echo "Remove Containers."
CONTAINERS=`docker ps -a -q`
if [ -n "$CONTAINERS" ] ; then
	echo $CONTAINERS | xargs docker stop | xargs docker rm
fi

docker build -t php:fpm-custom ${CURDIR}/php-fpm
docker build -t nginx:custom ${CURDIR}/nginx

docker run -d --name sc-mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=scpass mysql
docker run -d --name sc-php --link sc-mysql:mysql -v ${CURDIR}/src:/var/www/app php:fpm-custom
docker run -d -p 80:80 -p 443:443 --link sc-php:php -v ${CURDIR}/src:/var/www/app nginx:custom
