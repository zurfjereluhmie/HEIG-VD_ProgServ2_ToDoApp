#!/bin/sh
if docker-compose up -d; then
    echo ""
    echo "\033[1mWeb app\033[0m is running on http://localhost:80"
    echo "\033[1mMailhog\033[0m is running on http://localhost:8025"

    echo ""
    echo "To stop the app, run:"
    echo "    \033[3mdocker-compose down\033[0m"
fi