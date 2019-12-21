from mysql:latest
ENV MYSQL_ROOT_PASSWORD 123
ENV MYSQL_DATABASE renapdb
ENV MYSQL_USER usuario
ENV MYSQL_PASSWORD usuario
ADD bases.sql/docker-entrypoint-initdb.d
EXPOSE 3306
