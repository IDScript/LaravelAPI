#/bin/sh

FILE=.env
if test -f "$FILE"; then
    echo "$FILE exists."
else
    echo "Copy .env from .env.example"
    cp .env.example .env
fi
