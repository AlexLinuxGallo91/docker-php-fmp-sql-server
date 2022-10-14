FROM php:8.1-fpm

## instalacion del ODBC 18
RUN apt-get update -y && apt-get install -y gnupg2 dialog apt-utils telnet
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update -y
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql18
RUN ACCEPT_EULA=Y apt-get install -y mssql-tools18
RUN echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc
RUN /bin/bash -c 'source ~/.bashrc'

RUN apt-get install -y unixodbc-dev
# RUN apt-get install -y libgssapi-krb5-2

## instalacion drivers php
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv

