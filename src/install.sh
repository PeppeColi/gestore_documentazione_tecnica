#!/bin/bash

# Laravel stuff
php composer.phar install
php artisan migrate --seed
php artisan migrate --env=testing

# update to node v14.x
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
nvm install 14.0.0

# frontend stuff
npm install
npm run dev

# run test
php vendor/bin/phpunit
