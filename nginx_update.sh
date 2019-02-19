#! /bin/sh

echo "Updating / Restarting NGINX + RTMP"

/usr/local/nginx/sbin/nginx -s stop

mv /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf.old
cp /var/www/html/config/nginx.conf /usr/local/nginx/conf/nginx.conf

/usr/local/nginx/sbin/nginx

echo "Done"