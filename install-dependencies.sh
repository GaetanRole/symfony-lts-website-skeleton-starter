#!/bin/bash

echo -e "\n"
echo "Simple shell script running composer and npm install."
echo -e "\n"
  
composer install
composer update
npm install
npm run-script dev

echo -e "\n"
echo "Run 'bin/console d:d:c' and 'bin/console d:m:m' for your first install."
echo -e "\n"
