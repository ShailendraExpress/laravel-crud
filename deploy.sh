#!/bin/bash

echo "---- DEPLOY START ----"

cd /var/www/laravel-crud || exit

echo "Pull latest code"
git pull origin main

echo "Rebuild containers"
docker-compose down
docker-compose up -d --build

echo "---- DEPLOY DONE ----"
