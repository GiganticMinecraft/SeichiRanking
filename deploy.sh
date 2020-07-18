#!/bin/bash

cd /usr/local/bin/docker-compose/SeichiRanking
docker-compose build --no-cache
docker-compose stop
docker-compose rm -f
docker-compose up -d