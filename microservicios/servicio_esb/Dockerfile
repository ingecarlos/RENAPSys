FROM ubuntu:18.04

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update
RUN apt-get install -y apache2
RUN apt-get install -y php7.3 libapache2-mod-php php-mysql
RUN apt-get install -y php-dev php-bcmath php-json php-json-schema php-mbstring openssl php-tokenizer php-xml php-zip unzip


RUN rm -R /var/www/html

ADD . /var/www/html/
WORKDIR /var/www/html
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
EXPOSE 80