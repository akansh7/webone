#!/bin/sh
set -e

# Railway sets PORT; default to 8080 if not provided
export PORT="${PORT:-8080}"

# Render nginx config from template
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Start PHP-FPM in background
php-fpm -D

# Start nginx in foreground
exec nginx -g "daemon off;"
