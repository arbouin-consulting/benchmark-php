#!/bin/sh
set -e

echoerr() { echo "$@" 1>&2; }

DB_HOST_NAME=$(echo "$DB_HOST" | cut -d ":" -f 1)
DB_PORT_TMP=$(echo "$DB_HOST" | cut -sd ":" -f 2)
if [[ -z ${DB_PORT_TMP} ]]; then
  DB_PORT=${DB_PORT:-3306};
else
  DB_PORT=${DB_PORT_TMP};
fi

dockerize -wait tcp://${DB_HOST_NAME}:${DB_PORT} -timeout 15s

RESULT=$?

if [[ ${RESULT} -eq 0 ]]; then
  # sleep another second for so that we don't get a "the database system is starting up" error
  sleep 1
  echoerr "wait-for-db: done"
else
  echoerr "wait-for-db: timeout out after 15 seconds waiting for ${DB_HOST_NAME}:${DB_PORT}"
fi

php /srv/bench/generate-data-fake.php

exec "$@"
