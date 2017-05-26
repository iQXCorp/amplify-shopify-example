#!/bin/bash

function localtunnel {
lt --port 80 --subdomain amplifyphp
}

until localtunnel; do
echo "localtunnel server crashed"
sleep 2
done
