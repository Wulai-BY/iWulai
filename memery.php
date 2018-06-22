<?php
#阿里源
deb http://mirrors.aliyun.com/ubuntu/ trusty main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-security main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-updates main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-proposed main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ trusty-backports main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-security main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-updates main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-proposed main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ trusty-backports main restricted universe multiverse

/* Ubuntu LNMP 环境搭建 */
sudo apt-get install nginx
    /* rewrite moddle */
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        #proxy_pass  http://127.0.0.1:9501;
        /* 负载均衡 */
        upstream iwulai  {
            server 127.0.0.1:9501 weight=30;
            server 127.0.0.1:9502 weight=60;
            server 127.0.0.1:9503 weight=90;
        }
        location /iwulai/ {
            proxy_pass http://iwulai;
        }
    }

    location ~* \.(gif|jpg|jpeg|png|css|js)$ {
            expires 30d;
            valid_referers *.iwulai.com *.baidu.com;
            if ( $invalid_referer ) {
                    # rewrite ^/ http://img.iwulai.com/undifined.jpg;
                    return 404;
            }
    }

sudo apt-get install redis-server
sudo apt-get install git
sudo apt-get install composer
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
composer config -g repo.packagist composer https://packagist.phpcomposer.com
sudo apt-get install php7.2 php7.2-fpm php7.2-mysql php7.2-mbstring php7.2-xml php7.2-json php7.2-curl php7.2-gd
    /* swoole */
    sudo apt-get install php7.2-dev php-pear
    sudo pecl channel-update pecl.php.net
    sudo pecl install redis
    sudo pecl install swoole
        /* composer require --dev 'eaglewu/swoole-ide-helper:dev-master' */
    #https://github.com/LinkedDestiny/swoole-doc
sudo apt-get install mysql-server
    [mysql] 
    default-character-set = utf8mb4 
    [mysqld] 
    character-set-client-handshake = FALSE
    character-set-server = utf8mb4
    collation-server = utf8mb4_unicode_ci
    init_connect = 'SET NAMES utf8mb4'
    SHOW VARIABLES WHERE Variable_name LIKE 'character_set_%' OR Variable_name LIKE 'collation%';
    /* no password login */     //https://blog.csdn.net/YuYan_wang/article/details/79515940
    update user set authentication_string = PASSWORD( 'newpassword' ) where user = 'root';
    update user set plugin = 'mysql_native_password';
    flush privileges;
sudo apt-get install nodejs
audo apt-get install npm
    npm config set registry https://registry.npm.taobao.org
sudo npm install -g vue-cli
/* install chrome browser */
sudo wget http://www.linuxidc.com/files/repo/google-chrome.list -P /etc/apt/sources.list.d/
wget -q -O - https://dl.google.com/linux/linux_signing_key.pub  | sudo apt-key add -
sudo apt update
sudo apt install google-chrome-stable
