#!/bin/bash
cp -r /home/site/wwwroot/public/* /home/site/wwwroot/
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
