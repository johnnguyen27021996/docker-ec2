#!/bin/bash
set -e

echo ">>> Environment detected: ${APP_ENV}"

case "${APP_ENV}" in
  local)
    cp /etc/nginx/conf.d/default.conf.local /etc/nginx/conf.d/default.conf
    ;;
  dev)
    cp /etc/nginx/conf.d/default.conf.dev /etc/nginx/conf.d/default.conf
    ;;
  prd)
    cp /etc/nginx/conf.d/default.conf.prd /etc/nginx/conf.d/default.conf
    ;;
  *)
    echo "Unknown APP_ENV=${APP_ENV}, fallback to local"
    cp /etc/nginx/conf.d/default.conf.local /etc/nginx/conf.d/default.conf
    ;;
esac

echo ">>> Using nginx config: /etc/nginx/conf.d/default.conf"

exec "$@"
