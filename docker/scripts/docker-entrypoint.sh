#!/bin/sh

# init nginx
if [ ! -d "/var/tmp/nginx/client_body" ]; then
  mkdir -p /run/nginx /var/tmp/nginx/client_body
  chown nginx:nginx -R /run/nginx /var/tmp/nginx/
fi

php /var/www/html/artisan migrate

/usr/bin/npm install

exec "$@"
