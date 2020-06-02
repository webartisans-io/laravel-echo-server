FROM ubuntu:18.04

MAINTAINER Boudy de Geer "boudydegeer@mosaiqo.com"

WORKDIR /opt/app/

ENV DEBIAN_FRONTEND=noninteractive
RUN set -x \
    && apt-get update && apt-get install -y gnupg gosu tzdata nodejs npm \
    && gosu nobody true

ENV TERM xterm

RUN echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu bionic main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && echo "deb http://ppa.launchpad.net/nginx/development/ubuntu bionic main" > /etc/apt/sources.list.d/ppa_nginx_mainline.list \
    && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && apt-get update \
    && apt-get install -y curl zip unzip zsh wget git vim supervisor sqlite3 fonts-powerline \
    && apt-get install -y nginx php7.3-fpm php7.3-cli \
       php7.3-pgsql php7.3-sqlite3 php7.3-gd \
       php7.3-curl php7.3-memcached \
       php7.3-imap php7.3-mysql php7.3-mbstring \
       php7.3-xml php7.3-zip php7.3-bcmath php7.3-soap \
       php7.3-intl php7.3-readline php7.3-xdebug \
       php7.3-msgpack php7.3-igbinary php7.3-ldap \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf \
    && wget https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh \
    && sh install.sh && rm install.sh\
    && echo 'export PATH="$PATH:./vendor/bin:/usr/bin/zsh"' >> ~/.bash \
    && echo 'alias phpunit="./vendor/bin/phpunit -c phpunit.docker.xml"' >> ~/.bash \
    && echo 'alias bash="/usr/bin/zsh' >> ~/.bash \
    && chsh -s /usr/bin/zsh \
    && rm /root/.zshrc

COPY ./docker/app/h5bp /etc/nginx/h5bp
COPY ./docker/app/default /etc/nginx/sites-available/default
COPY ./docker/app/php-fpm.conf /etc/php/7.3/fpm/php-fpm.conf
COPY ./docker/app/xdebug.ini /etc/php/7.3/mods-available/xdebug.ini
COPY ./docker/app/app.ini /etc/php/7.3/fpm/conf.d/99-app.ini
COPY ./docker/app/.zshrc /root/.zshrc

EXPOSE 80

COPY ./docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/app/start-container /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container

COPY . /opt/app/

RUN composer install
RUN /usr/bin/npm install
RUN chown -R 0777 /opt/app
RUN chmod -R 0777 /opt/app/storage

ENTRYPOINT ["start-container"]
CMD ["supervisord", "-n", "-j", "/supervisord.pid"]
