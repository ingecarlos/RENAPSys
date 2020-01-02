FROM ubuntu:18.04


#Evitar interacción de consola cuando se ejecuta
ENV DEBIAN_FRONTEND noninteractive

#RUN ejecuta comandos dentro del container
RUN apt-get update
RUN apt-get install -y apache2
RUN apt-get install -y php libapache2-mod-php php-mysql
RUN apt-get install -y php-dev php-bcmath php-json php-json-schema php-mbstring openssl php-tokenizer php-xml php-zip unzip
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

RUN mv composer.phar /usr/local/bin/composer
RUN rm /var/www/html/*

ADD . /var/www/html/
WORKDIR /var/www/html


