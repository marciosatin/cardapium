FROM php:7.4-fpm

USER root

ADD install_dependencies.sh /install_dependencies.sh

RUN chmod +x /install_dependencies.sh

RUN cd / && ./install_dependencies.sh

WORKDIR /var/www/html
