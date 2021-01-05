#!/bin/bash
set -Ceuo pipefail

local NAME='my:up'
local DESCRIPTION='Start up my development environment'

handle() {
  cp -f ../.laradock/env-development .env
  docker-compose up -d --build mysql workspace
  docker-compose exec -u laradock workspace composer install
  cp ../phpunit.xml.dist ../phpunit.xml
  sed -i 's/name="TEST_DB_HOST" value=""/name="TEST_DB_HOST" value="mysql"/g' ../phpunit.xml
  sed -i 's/name="TEST_DB_PASSWORD" value=""/name="TEST_DB_PASSWORD" value="root"/g' ../phpunit.xml
  if ! docker-compose exec workspace bash -c 'test -f /usr/local/bin/phive'; then
    docker-compose exec workspace curl -fsSL https://phar.io/releases/phive.phar -o /tmp/phive.phar
    docker-compose exec workspace curl -fsSL https://phar.io/releases/phive.phar.asc -o /tmp/phive.phar.asc
    docker-compose exec workspace gpg --keyserver ipv4.pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79
    docker-compose exec workspace gpg --verify /tmp/phive.phar.asc /tmp/phive.phar
    docker-compose exec workspace chmod +x /tmp/phive.phar
    docker-compose exec workspace mv /tmp/phive.phar /usr/local/bin/phive
  fi
  docker-compose exec -u laradock workspace phive --home .laradock/data/phive install
}
