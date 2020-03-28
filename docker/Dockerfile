FROM wartisans/docker-php:latest

MAINTAINER Boudy de Geer <boudydegeer@webartisans.es>

RUN \
  # install
  apk add -U --no-cache \
    memcached \
    vim \
    nginx \
    redis \
    supervisor \
  # cleanup
  && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* /usr/share/doc/* /usr/share/man/*

# nginx config
COPY ./docker/config/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/config/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# resource
COPY ./docker/config/php/index.php /var/www/html/index.php

# supervisor config
COPY \
  ./docker/config/memcached/memcached.ini \
  ./docker/config/nginx/nginx.ini \
  ./docker/config/php/php-fpm.ini \
  ./docker/config/websockets/websockets.ini \
    /etc/supervisor.d/

# entrypoint
COPY ./docker/scripts/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

COPY ./ /var/www/html
RUN chmod -R 0777 ./storage
# ports
EXPOSE 80

# commands
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["supervisord", "-n", "-j", "/supervisord.pid"]
