#!/bin/bash

docker compose -f docker-compose.prd.yml exec app php artisan ranking:count
