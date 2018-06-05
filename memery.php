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

/* Ubuntu LNMP 环境搭建 */
sudo apt-get install nginx
    /* rewrite moddle */
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
sudo apt-get install php7.2 php7.2-fpm php7.2-mysql php7.2-mbstring php7.2-xml php7.2-json php7.2-curl php7.2-gd
    /* swoole */
    sudo apt-get install php7.2-dev php-pear libpq-dev
    sudo pecl channel-update pecl.php.net
    sudo pecl install swoole
    #https://github.com/LinkedDestiny/swoole-doc
sudo apt-get install mysql-server
    /* no password login */     //https://blog.csdn.net/YuYan_wang/article/details/79515940
    update user set authentication_string = PASSWORD( 'newpassword' ) where user = 'root';
    update user set plugin = 'mysql_native_password';
    flush privileges;

/* install chrome browser */
sudo wget http://www.linuxidc.com/files/repo/google-chrome.list -P /etc/apt/sources.list.d/
wget -q -O - https://dl.google.com/linux/linux_signing_key.pub  | sudo apt-key add -
sudo apt update
sudo apt install google-chrome-stable
