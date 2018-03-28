<?php
/* Ubuntu LAMP 环境搭建 */
sudo apt-get install apache2
    /* apache.conf *
    AddType application/x-httpd-php .php .html
    AddDefaultCharset utf-8
    */
sudo a2enmod ssl
sudo ln -s /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf
sudo apt-get install php7.0
sudo apt-get install php7.0-mysql
sudo apt-get install php7.0-mbstring
sudo apt-get install php7.0-xml
sudo apt-get install mysql-server mysql-client
sudo apt-get install libapache2-mod-php7.0
sudo apt-get install redis-server
sudo apt-get install git
sudo apt-get install composer
composer config -g repo.packagist composer https://packagist.phpcomposer.com
