#! /bin/sh

echo "Stopped NGINX + RTMP"

/usr/local/nginx/sbin/nginx -s stop

echo "Done"