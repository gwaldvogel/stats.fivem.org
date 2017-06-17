#!/usr/bin/env bash

if [ ! -f artisan ]; then
	echo 'Only run this script from the projects root folder'
	exit 1
fi

# Parse arguments
while [[ $# -gt 1 ]]
do
key="$1"
case $key in
    --force)
    FORCE=YES
    ;;
    *)
    echo 'Invalid argument'
    exit 1
    ;;
esac
shift
done

echo 'Deploying stats.fivem.org...'
git pull
composer install
if [ $FORCE ]; then
	php artisan migrate --force
else
	php artisan migrate --force
fi

php artisan git:version
php artisan cache:clear
php artisan cache:serverlist