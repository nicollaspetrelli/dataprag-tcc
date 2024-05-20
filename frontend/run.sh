#!/bin/sh

DIR="./node_modules/"
if [ -d "$DIR" ]
then
    if [ "$(ls -A $DIR)" ]; then
        echo "Take action $DIR is not Empty"
        npm start
    else
        echo "$DIR is Empty"
        npm install
        npm start
    fi
else
    echo "Directory $DIR not found."
    npm install
    npm start
fi