server {

    listen 80;
    charset utf-8;
    server_name local.iwulai.com;
    root /www/html/iwulai/public;
    index index.php;
	
    return 301 https://$server_name$request_uri;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/www/run/php-fpm.sock;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_read_timeout 600;
    }

    location ~ /\.(ht|ini|cnf|conf) {
        deny all;
    }
	
}

server {

    listen 443;
    charset utf-8;
    server_name www.iwulai.com;
	
    ssl on;
    ssl_certificate   cert/www.iwulai.com/.pem;
    ssl_certificate_key  cert/www.iwulai.com/.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
	
    root /www/html/iwulai/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/www/run/php-fpm.sock;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_read_timeout 600;
    }

    location ~ /\.(ht|ini|cnf|conf) {
        deny all;
    }
	
}

server {
    server_name iwulai.com;
	rewrite ^(.*)$ http://www.iwulai.com$1 permanent;
}
